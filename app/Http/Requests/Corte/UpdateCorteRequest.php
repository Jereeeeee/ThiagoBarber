<?php

namespace App\Http\Requests\Corte;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCorteRequest extends FormRequest
{
    /**
     * Separar errores del formulario de edicion.
     *
     * @var string
     */
    protected $errorBag = 'updateCorte';

    /**
     * Autorizar la solicitud.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas de validacion para editar un corte.
     *
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'corte_id' => ['required', 'integer', 'exists:cortes,id'],
            'titulo' => ['required', 'string', 'max:120'],
            'imagen' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:4096'],
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
            'corte_id.required' => 'No se encontro el corte a editar.',
            'corte_id.exists' => 'El corte seleccionado no existe.',
            'titulo.required' => 'El nombre del corte es obligatorio.',
            'titulo.string' => 'El nombre del corte debe ser un texto valido.',
            'titulo.max' => 'El nombre del corte no puede superar los 120 caracteres.',
            'imagen.image' => 'El archivo debe ser una imagen valida.',
            'imagen.mimes' => 'La imagen debe ser JPG, JPEG, PNG, WEBP o GIF.',
            'imagen.max' => 'La imagen no puede superar los 4 MB.',
        ];
    }
}