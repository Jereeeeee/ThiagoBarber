<?php

namespace App\Http\Requests\Producto;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductoRequest extends FormRequest
{
    /**
     * Separar errores del formulario de creacion.
     *
     * @var string
     */
    protected $errorBag = 'storeProducto';

    /**
     * Autorizar la solicitud.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas de validacion para crear un producto.
     *
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'submission_token' => ['required', 'string', 'uuid'],
            'titulo' => ['required', 'string', 'max:120'],
            'descripcion' => ['required', 'string', 'max:400'],
            'etiqueta' => ['required', 'string', 'max:60'],
            'precio' => ['required', 'integer', 'min:0', 'max:999999999'],
            'imagen' => ['required', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:4096'],
        ];
    }

    /**
     * Mensajes personalizados.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'submission_token.required' => 'No se pudo validar el envio del formulario. Intenta nuevamente.',
            'submission_token.uuid' => 'El identificador de envio no es valido. Recarga la pagina e intenta de nuevo.',
            'titulo.required' => 'El nombre del producto es obligatorio.',
            'titulo.string' => 'El nombre del producto debe ser un texto valido.',
            'titulo.max' => 'El nombre del producto no puede superar los 120 caracteres.',
            'descripcion.required' => 'La descripcion del producto es obligatoria.',
            'descripcion.max' => 'La descripcion no puede superar los 400 caracteres.',
            'etiqueta.required' => 'La etiqueta del producto es obligatoria.',
            'etiqueta.max' => 'La etiqueta no puede superar los 60 caracteres.',
            'precio.required' => 'El precio del producto es obligatorio.',
            'precio.integer' => 'El precio debe ser un numero entero valido.',
            'precio.min' => 'El precio no puede ser negativo.',
            'precio.max' => 'El precio es demasiado alto.',
            'imagen.required' => 'Debes subir una imagen para el producto.',
            'imagen.image' => 'El archivo debe ser una imagen valida.',
            'imagen.mimes' => 'La imagen debe ser JPG, JPEG, PNG, WEBP o GIF.',
            'imagen.max' => 'La imagen no puede superar los 4 MB.',
        ];
    }
}
