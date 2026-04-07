<?php

namespace App\Http\Controllers;

use App\Http\Requests\Corte\StoreCorteRequest;
use App\Http\Requests\Corte\UpdateCorteRequest;
use App\Models\Corte;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CorteController extends Controller
{
    /**
     * Mostrar el catalogo de cortes.
     */
    public function index(): View
    {
        $submissionToken = (string) Str::uuid();
        $submissionTokens = session('corte_submission_tokens', []);
        $submissionTokens[] = $submissionToken;

        session([
            'corte_submission_tokens' => array_slice(array_values(array_unique($submissionTokens)), -20),
        ]);

        return view('cortes', [
            'cortes' => Corte::query()->latest()->get(),
            'submissionToken' => $submissionToken,
            'administradores' => $this->administradores(),
        ]);
    }

    /**
     * Guardar un nuevo corte.
     */
    public function store(StoreCorteRequest $request): RedirectResponse
    {
        if (! $this->administradores()) {
            return redirect()
                ->route('cortes')
                ->with('error', 'No tienes permisos para agregar cortes.');
        }

        $validated = $request->validated();
        $submissionTokens = session('corte_submission_tokens', []);
        $tokenIndex = array_search($validated['submission_token'], $submissionTokens, true);

        if ($tokenIndex === false) {
            return redirect()
                ->route('cortes')
                ->with('error', 'Esta solicitud ya fue procesada. Presiona una sola vez el boton Guardar corte.');
        }

        unset($submissionTokens[$tokenIndex]);
        session([
            'corte_submission_tokens' => array_values($submissionTokens),
        ]);

        $image = $validated['imagen'];
        $directory = public_path('images/cortes');

        File::ensureDirectoryExists($directory);

        $fileName = Str::slug($validated['titulo']).'-'.Str::random(8).'.'.$image->getClientOriginalExtension();
        $image->move($directory, $fileName);

        Corte::create([
            'titulo' => $validated['titulo'],
            'imagen_path' => 'images/cortes/'.$fileName,
        ]);

        return redirect()
            ->route('cortes')
            ->with('success', 'El nuevo corte fue creado correctamente.');
    }

    /**
     * Actualizar una tarjeta de corte existente.
     */
    public function update(UpdateCorteRequest $request, Corte $corte): RedirectResponse
    {
        if (! $this->administradores()) {
            return redirect()
                ->route('cortes')
                ->with('error', 'No tienes permisos para editar cortes.');
        }

        $validated = $request->validated();
        $newImagePath = $corte->imagen_path;

        if ($request->hasFile('imagen')) {
            $image = $validated['imagen'];
            $directory = public_path('images/cortes');

            File::ensureDirectoryExists($directory);

            $fileName = Str::slug($validated['titulo']).'-'.Str::random(8).'.'.$image->getClientOriginalExtension();
            $image->move($directory, $fileName);
            $newImagePath = 'images/cortes/'.$fileName;

            if (Str::startsWith($corte->imagen_path, 'images/cortes/')) {
                $oldImageAbsolutePath = public_path($corte->imagen_path);

                if (File::exists($oldImageAbsolutePath)) {
                    File::delete($oldImageAbsolutePath);
                }
            }
        }

        $corte->update([
            'titulo' => $validated['titulo'],
            'imagen_path' => $newImagePath,
        ]);

        return redirect()
            ->route('cortes')
            ->with('success', 'La tarjeta del corte fue actualizada correctamente.');
    }

    /**
     * Eliminar una tarjeta de corte.
     */
    public function destroy(int $corte): RedirectResponse
    {
        if (! $this->administradores()) {
            return redirect()
                ->route('cortes')
                ->with('error', 'No tienes permisos para eliminar cortes.');
        }

        $corteModel = Corte::query()->find($corte);

        if (! $corteModel instanceof Corte) {
            return redirect()
                ->route('cortes')
                ->with('error', 'El corte que intentaste eliminar ya no existe.');
        }

        if (Str::startsWith($corteModel->imagen_path, 'images/cortes/')) {
            $imageAbsolutePath = public_path($corteModel->imagen_path);

            if (File::exists($imageAbsolutePath)) {
                File::delete($imageAbsolutePath);
            }
        }

        $corteModel->delete();

        return redirect()
            ->route('cortes')
            ->with('success', 'La tarjeta del corte fue eliminada correctamente.');
    }

    /**
     * Indicar si el usuario autenticado puede gestionar el catalogo.
     */
    private function administradores(): bool
    {
        $user = Auth::user();

        if (! $user) {
            return false;
        }

        return in_array((int) $user->role_id, [1, 3], true);
    }
}