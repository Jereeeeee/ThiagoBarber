<?php

namespace App\Http\Controllers;

use App\Http\Requests\Curso\StoreCursoRequest;
use App\Http\Requests\Curso\UpdateCursoRequest;
use App\Models\Curso;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CursoController extends Controller
{
    /**
     * Mostrar el catalogo de cursos.
     */
    public function index(): View
    {
        $submissionToken = (string) Str::uuid();
        $submissionTokens = session('curso_submission_tokens', []);
        $submissionTokens[] = $submissionToken;

        session([
            'curso_submission_tokens' => array_slice(array_values(array_unique($submissionTokens)), -20),
        ]);

        return view('cursos', [
            'cursos' => Curso::query()->latest()->get(),
            'submissionToken' => $submissionToken,
            'administradores' => $this->administradores(),
              'whatsappReserveMessage' => rawurlencode('Hola!! 👋 Quiero reservar curso 💈'),
        ]);
    }

    /**
     * Guardar un nuevo curso.
     */
    public function store(StoreCursoRequest $request): RedirectResponse
    {
        if (! $this->administradores()) {
            return redirect()
                ->route('cursos')
                ->with('error', 'No tienes permisos para agregar cursos.');
        }

        $validated = $request->validated();
        $submissionTokens = session('curso_submission_tokens', []);
        $tokenIndex = array_search($validated['submission_token'], $submissionTokens, true);

        if ($tokenIndex === false) {
            return redirect()
                ->route('cursos')
                ->with('error', 'Esta solicitud ya fue procesada. Presiona una sola vez el boton Guardar curso.');
        }

        unset($submissionTokens[$tokenIndex]);
        session([
            'curso_submission_tokens' => array_values($submissionTokens),
        ]);

        Curso::query()->create([
            'titulo' => $validated['titulo'],
            'slug' => $this->buildUniqueSlug($validated['titulo']),
            'descripcion' => $validated['descripcion'],
            'imagen_path' => $this->storeCursoImage($validated['imagen'], $validated['titulo']),
            'precio' => (float) $validated['precio'],
            'is_active' => true,
        ]);

        return redirect()
            ->route('cursos')
            ->with('success', 'El nuevo curso fue creado correctamente.');
    }

    /**
     * Actualizar un curso existente.
     */
    public function update(UpdateCursoRequest $request, Curso $curso): RedirectResponse
    {
        if (! $this->administradores()) {
            return redirect()
                ->route('cursos')
                ->with('error', 'No tienes permisos para editar cursos.');
        }

        $validated = $request->validated();
        $newImagePath = $curso->imagen_path;

        if ($request->hasFile('imagen')) {
            $newImagePath = $this->storeCursoImage($validated['imagen'], $validated['titulo']);

            if (Str::startsWith((string) $curso->imagen_path, 'images/cursos/')) {
                $oldImageAbsolutePath = public_path($curso->imagen_path);

                if (File::exists($oldImageAbsolutePath)) {
                    File::delete($oldImageAbsolutePath);
                }
            }
        }

        $curso->update([
            'titulo' => $validated['titulo'],
            'slug' => $this->buildUniqueSlug($validated['titulo'], $curso->id),
            'descripcion' => $validated['descripcion'],
            'imagen_path' => $newImagePath,
            'precio' => (float) $validated['precio'],
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()
            ->route('cursos')
            ->with('success', 'La tarjeta del curso fue actualizada correctamente.');
    }

    /**
     * Eliminar una tarjeta de curso.
     */
    public function destroy(int $curso): RedirectResponse
    {
        if (! $this->administradores()) {
            return redirect()
                ->route('cursos')
                ->with('error', 'No tienes permisos para eliminar cursos.');
        }

        $cursoModel = Curso::query()->find($curso);

        if (! $cursoModel instanceof Curso) {
            return redirect()
                ->route('cursos')
                ->with('error', 'El curso que intentaste eliminar ya no existe.');
        }

        if (Str::startsWith((string) $cursoModel->imagen_path, 'images/cursos/')) {
            $imageAbsolutePath = public_path($cursoModel->imagen_path);

            if (File::exists($imageAbsolutePath)) {
                File::delete($imageAbsolutePath);
            }
        }

        $cursoModel->delete();

        return redirect()
            ->route('cursos')
            ->with('success', 'La tarjeta del curso fue eliminada correctamente.');
    }

    /**
     * Determinar si el usuario autenticado tiene permisos administrativos.
     */
    private function administradores(): bool
    {
        $user = Auth::user();

        if (! $user) {
            return false;
        }

        return in_array((int) $user->role_id, [1, 3], true);
    }

    /**
     * Construir un slug unico para el curso.
     */
    private function buildUniqueSlug(string $titulo, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($titulo);

        if ($baseSlug === '') {
            $baseSlug = 'curso';
        }

        $slug = $baseSlug;
        $counter = 2;

        while ($this->slugExists($slug, $ignoreId)) {
            $slug = $baseSlug.'-'.$counter;
            $counter++;
        }

        return $slug;
    }

    /**
     * Comprobar si un slug ya existe en la base de datos.
     */
    private function slugExists(string $slug, ?int $ignoreId = null): bool
    {
        return Curso::query()
            ->when($ignoreId !== null, fn ($query) => $query->where('id', '!=', $ignoreId))
            ->where('slug', $slug)
            ->exists();
    }

    /**
     * Guardar la imagen del curso y devolver su ruta publica.
     */
    private function storeCursoImage(mixed $image, string $titulo): string
    {
        $directory = public_path('images/cursos');

        File::ensureDirectoryExists($directory);

        $fileName = Str::slug($titulo).'-'.Str::random(8).'.'.$image->getClientOriginalExtension();
        $image->move($directory, $fileName);

        return 'images/cursos/'.$fileName;
    }
}
