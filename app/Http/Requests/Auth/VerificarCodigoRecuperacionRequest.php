<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class VerificarCodigoRecuperacionRequest extends FormRequest
{
    /**
     * Autorizar la solicitud de verificacion de codigo.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas de validacion para comprobar el codigo de 6 digitos.
     *
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'exists:users,email'],
            'code' => ['required', 'digits:6'],
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
            'email.required' => 'Debes ingresar tu correo para validar el codigo.',
            'email.email' => 'El correo ingresado no es valido.',
            'email.exists' => 'No encontramos una cuenta registrada con ese correo.',
            'code.required' => 'Debes ingresar el codigo de verificacion.',
            'code.digits' => 'El codigo debe contener exactamente 6 digitos.',
        ];
    }
}
