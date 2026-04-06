<?php

namespace App\Http\Controllers;

use App\Http\Requests\Producto\StoreProductoRequest;
use App\Http\Requests\Producto\UpdateProductoRequest;
use App\Models\Producto;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProductoController extends Controller
{
    /**
     * Mostrar el catalogo de productos.
     */
    public function index(): View
    {
        $submissionToken = (string) Str::uuid();
        $submissionTokens = session('producto_submission_tokens', []);
        $submissionTokens[] = $submissionToken;

        session([
            'producto_submission_tokens' => array_slice(array_values(array_unique($submissionTokens)), -20),
        ]);

        return view('productos', [
            'productos' => Producto::query()->latest()->get(),
            'submissionToken' => $submissionToken,
        ]);
    }

    /**
     * Guardar un nuevo producto.
     */
    public function store(StoreProductoRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $submissionTokens = session('producto_submission_tokens', []);
        $tokenIndex = array_search($validated['submission_token'], $submissionTokens, true);

        if ($tokenIndex === false) {
            return redirect()
                ->route('productos')
                ->with('error', 'Esta solicitud ya fue procesada. Presiona una sola vez el boton Guardar producto.');
        }

        unset($submissionTokens[$tokenIndex]);
        session([
            'producto_submission_tokens' => array_values($submissionTokens),
        ]);

        $image = $validated['imagen'];
        $directory = public_path('images/productos');

        File::ensureDirectoryExists($directory);

        $fileName = Str::slug($validated['titulo']).'-'.Str::random(8).'.'.$image->getClientOriginalExtension();
        $image->move($directory, $fileName);

        Producto::query()->create([
            'titulo' => $validated['titulo'],
            'descripcion' => $validated['descripcion'],
            'etiqueta' => $validated['etiqueta'],
            'precio' => (int) $validated['precio'],
            'imagen_path' => 'images/productos/'.$fileName,
        ]);

        return redirect()
            ->route('productos')
            ->with('success', 'El nuevo producto fue creado correctamente.');
    }

    /**
     * Actualizar un producto existente.
     */
    public function update(UpdateProductoRequest $request, Producto $producto): RedirectResponse
    {
        $validated = $request->validated();
        $newImagePath = $producto->imagen_path;

        if ($request->hasFile('imagen')) {
            $image = $validated['imagen'];
            $directory = public_path('images/productos');

            File::ensureDirectoryExists($directory);

            $fileName = Str::slug($validated['titulo']).'-'.Str::random(8).'.'.$image->getClientOriginalExtension();
            $image->move($directory, $fileName);
            $newImagePath = 'images/productos/'.$fileName;

            if (Str::startsWith($producto->imagen_path, 'images/productos/')) {
                $oldImageAbsolutePath = public_path($producto->imagen_path);

                if (File::exists($oldImageAbsolutePath)) {
                    File::delete($oldImageAbsolutePath);
                }
            }
        }

        $producto->update([
            'titulo' => $validated['titulo'],
            'descripcion' => $validated['descripcion'],
            'etiqueta' => $validated['etiqueta'],
            'precio' => (int) $validated['precio'],
            'imagen_path' => $newImagePath,
        ]);

        return redirect()
            ->route('productos')
            ->with('success', 'La tarjeta del producto fue actualizada correctamente.');
    }

    /**
     * Eliminar una tarjeta de producto.
     */
    public function destroy(int $producto): RedirectResponse
    {
        $productoModel = Producto::query()->find($producto);

        if (! $productoModel instanceof Producto) {
            return redirect()
                ->route('productos')
                ->with('error', 'El producto que intentaste eliminar ya no existe.');
        }

        if (Str::startsWith($productoModel->imagen_path, 'images/productos/')) {
            $imageAbsolutePath = public_path($productoModel->imagen_path);

            if (File::exists($imageAbsolutePath)) {
                File::delete($imageAbsolutePath);
            }
        }

        $productoModel->delete();

        return redirect()
            ->route('productos')
            ->with('success', 'La tarjeta del producto fue eliminada correctamente.');
    }
}
