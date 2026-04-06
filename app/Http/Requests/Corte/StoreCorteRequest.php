<?php

namespace App\Http\Requests\Corte;

use Illuminate\Foundation\Http\FormRequest;

class StoreCorteRequest extends FormRequest
{
    /**
     * Separar errores del formulario de creacion.
     *
     * @var string
     */
    protected $errorBag = 'storeCorte';

    /**
     * Autorizar la solicitud.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas de validacion para crear un corte.
     *
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'submission_token' => ['required', 'string', 'uuid'],
            'titulo' => ['required', 'string', 'max:120'],
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
            'titulo.required' => 'El nombre del corte es obligatorio.',
            'titulo.string' => 'El nombre del corte debe ser un texto valido.',
            'titulo.max' => 'El nombre del corte no puede superar los 120 caracteres.',
            'imagen.required' => 'Debes subir una imagen para el corte.',
            'imagen.image' => 'El archivo debe ser una imagen valida.',
            'imagen.mimes' => 'La imagen debe ser JPG, JPEG, PNG, WEBP o GIF.',
            'imagen.max' => 'La imagen no puede superar los 4 MB.',
        ];
    }
}