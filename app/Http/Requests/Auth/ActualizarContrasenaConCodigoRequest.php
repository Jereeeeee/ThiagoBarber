<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class ActualizarContrasenaConCodigoRequest extends FormRequest
{
    /**
     * Autorizar la solicitud de cambio de contrasena.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas de validacion para definir la nueva contrasena.
     *
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }

    /**
     * Mensajes personalizados de validacion.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'password.required' => 'Debes ingresar una nueva contrasena.',
            'password.min' => 'La nueva contrasena debe tener al menos 8 caracteres.',
            'password.confirmed' => 'La confirmacion de contrasena no coincide.',
        ];
    }
}
