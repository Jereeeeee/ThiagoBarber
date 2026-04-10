<?php

namespace Tests\Feature\Auth;

use App\Mail\CodigoRecuperacionMail;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ForgotPasswordFlowTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Verificar que al solicitar recuperacion se envia correo y se guarda token.
     */
    public function Verifica_solicitud_recuperacion(): void
    {
        Mail::fake();

        $user = User::factory()->create([
            'email' => 'cliente@example.com',
        ]);

        $response = $this->post(route('contrasena.olvidada.enviar_codigo'), [
            'email' => $user->email,
        ]);

        $response->assertRedirect(route('contrasena.codigo.formulario'));
        $response->assertSessionHas('password_reset_email', $user->email);

        Mail::assertSent(CodigoRecuperacionMail::class, function (CodigoRecuperacionMail $mail) use ($user): bool {
            return $mail->hasTo($user->email);
        });

        $tokenRecord = DB::table('password_reset_tokens')->where('email', $user->email)->first();

        $this->assertNotNull($tokenRecord);
        $this->assertNotEmpty((string) $tokenRecord->token);
    }

    /**
     * Verificar flujo completo: validar codigo y actualizar contrasena.
     */
    public function Verifica_flujo_completo(): void
    {
        $user = User::factory()->create([
            'email' => 'cliente@example.com',
            'password' => 'contrasena-anterior',
        ]);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $user->email],
            [
                'token' => Hash::make('123456'),
                'created_at' => now(),
            ]
        );

        $verifyResponse = $this->post(route('contrasena.codigo.verificar'), [
            'email' => $user->email,
            'code' => '123456',
        ]);

        $verifyResponse->assertRedirect(route('contrasena.nueva.formulario'));

        $resetResponse = $this->post(route('contrasena.nueva.guardar'), [
            'password' => 'nueva-clave-2026',
            'password_confirmation' => 'nueva-clave-2026',
        ]);

        $resetResponse->assertRedirect(route('login'));

        $updatedUser = $user->fresh();

        $this->assertTrue(Hash::check('nueva-clave-2026', (string) $updatedUser?->password));
        $this->assertDatabaseMissing('password_reset_tokens', ['email' => $user->email]);
    }
}
