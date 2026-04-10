<?php

namespace Tests\Feature\Auth;

use App\Mail\CodigoRecuperacionMail;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class TestCorreo extends TestCase
{
    use RefreshDatabase;

    /**
     * Verificar que se envia el correo de recuperacion cuando el usuario
     * solicita el codigo con un email registrado en la base de datos.
     */
    public function test_se_envia_correo_de_recuperacion(): void
    {
        Mail::fake();

        $user = User::factory()->create([
            'email' => 'cliente@example.com',
        ]);

        $response = $this->post(route('contrasena.olvidada.enviar_codigo'), [
            'email' => $user->email,
        ]);

        $response->assertRedirect(route('contrasena.codigo.formulario'));

        Mail::assertSent(CodigoRecuperacionMail::class, function (CodigoRecuperacionMail $mail) use ($user): bool {
            return $mail->hasTo($user->email);
        });
    }
}
