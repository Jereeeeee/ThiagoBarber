<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CodigoRecuperacionMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    /**
     * Codigo numerico de 6 digitos para recuperar la contrasena.
     */
    public function __construct(public string $code)
    {
    }

    /**
     * Definir asunto del correo de recuperacion.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Codigo de recuperación de contraseña',
        );
    }

    /**
     * Definir la vista utilizada para el contenido del correo.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.auth.codigo-recuperacion',
            with: ['code' => $this->code],
        );
    }
}
