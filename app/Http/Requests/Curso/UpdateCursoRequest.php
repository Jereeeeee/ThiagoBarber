<?php

namespace App\Http\Requests\Curso;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCursoRequest extends FormRequest
{
    /**
     * Separar errores del formulario de edicion.
     *
     * @var string
     */
    protected $errorBag = 'updateCurso';

    /**
     * Autorizar la solicitud.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas de validacion para editar un curso.
     *
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'curso_id' => ['required', 'integer', 'exists:cursos,id'],
            'titulo' => ['required', 'string', 'max:120'],
            'descripcion' => ['required', 'string', 'max:255'],
            'imagen' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:4096'],
            'precio' => ['required', 'numeric', 'min:0', 'max:99999999.99'],
            'is_active' => ['nullable', 'boolean'],
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
            'curso_id.required' => 'No se encontro el curso a editar.',
            'curso_id.exists' => 'El curso seleccionado no existe.',
            'titulo.required' => 'El nombre del curso es obligatorio.',
            'titulo.max' => 'El nombre del curso no puede superar los 120 caracteres.',
            'descripcion.required' => 'La descripcion del curso es obligatoria.',
            'descripcion.max' => 'La descripcion no puede superar los 255 caracteres.',
            'imagen.image' => 'El archivo debe ser una imagen valida.',
            'imagen.mimes' => 'La imagen debe ser JPG, JPEG, PNG, WEBP o GIF.',
            'imagen.max' => 'La imagen no puede superar los 4 MB.',
            'precio.required' => 'El precio del curso es obligatorio.',
            'precio.numeric' => 'El precio debe ser un numero valido.',
            'precio.min' => 'El precio no puede ser negativo.',
            'precio.max' => 'El precio no puede superar 99.999.999,99.',
            'is_active.boolean' => 'El estado del curso no es valido.',
        ];
    }
}
