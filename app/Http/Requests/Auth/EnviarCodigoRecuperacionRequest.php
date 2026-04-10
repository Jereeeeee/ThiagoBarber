<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class EnviarCodigoRecuperacionRequest extends FormRequest
{
    /**
     * Autorizar la solicitud de envio de codigo.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas de validacion para identificar la cuenta.
     *
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'exists:users,email'],
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
            'email.required' => 'Debes ingresar el correo asociado a tu cuenta.',
            'email.email' => 'El correo ingresado no es valido.',
            'email.exists' => 'No encontramos una cuenta registrada con ese correo.',
        ];
    }
}
