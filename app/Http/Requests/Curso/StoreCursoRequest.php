<?php

namespace App\Http\Requests\Curso;

use Illuminate\Foundation\Http\FormRequest;

class StoreCursoRequest extends FormRequest
{
    /**
     * Separar errores del formulario de creacion.
     *
     * @var string
     */
    protected $errorBag = 'storeCurso';

    /**
     * Autorizar la solicitud.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas de validacion para crear un curso.
     *
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'submission_token' => ['required', 'string', 'uuid'],
            'titulo' => ['required', 'string', 'max:120'],
            'descripcion' => ['required', 'string', 'max:600'],
            'imagen' => ['required', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:4096'],
            'precio' => ['required', 'numeric', 'min:0', 'max:999999999'],
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
            'titulo.required' => 'El nombre del curso es obligatorio.',
            'titulo.max' => 'El nombre del curso no puede superar los 120 caracteres.',
            'descripcion.required' => 'La descripcion del curso es obligatoria.',
            'descripcion.max' => 'La descripcion no puede superar los 600 caracteres.',
            'imagen.required' => 'Debes subir una imagen para el curso.',
            'imagen.image' => 'El archivo debe ser una imagen valida.',
            'imagen.mimes' => 'La imagen debe ser JPG, JPEG, PNG, WEBP o GIF.',
            'imagen.max' => 'La imagen no puede superar los 4 MB.',
            'precio.required' => 'El precio del curso es obligatorio.',
            'precio.numeric' => 'El precio debe ser un numero valido.',
            'precio.min' => 'El precio no puede ser negativo.',
            'precio.max' => 'El precio es demasiado alto.',
        ];
    }
}
