<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ActualizarContrasenaConCodigoRequest;
use App\Http\Requests\Auth\EnviarCodigoRecuperacionRequest;
use App\Http\Requests\Auth\VerificarCodigoRecuperacionRequest;
use App\Mail\CodigoRecuperacionMail;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class RecuperarContrasenaController extends Controller
{
    /**
     * Tiempo maximo (minutos) para usar el codigo enviado por correo.
     */
    private const CODE_TTL_MINUTES = 10;

    /**
     * Tiempo maximo (minutos) para permitir cambio de contrasena luego de verificar codigo.
     */
    private const VERIFIED_TTL_MINUTES = 15;

    /**
     * Mostrar pantalla para solicitar recuperacion de contrasena.
     */
    public function mostrarFormularioSolicitud(): View
    {
        return view('auth.recuperar-contrasena');
    }

    /**
     * Enviar codigo de verificacion de 6 digitos al correo asociado.
     */
    public function enviarCodigo(EnviarCodigoRecuperacionRequest $request): RedirectResponse
    {
        $email = (string) $request->validated('email');
        $code = (string) random_int(100000, 999999);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $email],
            [
                'token' => Hash::make($code),
                'created_at' => now(),
            ]
        );

        Mail::to($email)->send(new CodigoRecuperacionMail($code));

        $request->session()->put('password_reset_email', $email);
        $request->session()->forget(['password_reset_verified_email', 'password_reset_verified_at']);

        return redirect()
            ->route('contrasena.codigo.formulario')
            ->with('success', 'Enviamos un codigo de 6 digitos a tu correo. Revisa tu bandeja de entrada.');
    }

    /**
     * Mostrar pantalla para ingresar codigo recibido.
     */
    public function mostrarFormularioCodigo(Request $request): View|RedirectResponse
    {
        $email = (string) $request->session()->get('password_reset_email', '');

        if ($email === '') {
            return redirect()
                ->route('contrasena.olvidada')
                ->with('error', 'Primero debes solicitar un codigo de recuperacion.');
        }

        return view('auth.verificar-codigo-recuperacion', [
            'email' => $email,
        ]);
    }

    /**
     * Validar codigo de recuperacion ingresado por el cliente.
     */
    public function verificarCodigo(VerificarCodigoRecuperacionRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $email = (string) $validated['email'];
        $code = (string) $validated['code'];

        $tokenRecord = DB::table('password_reset_tokens')->where('email', $email)->first();

        if (! $tokenRecord) {
            return back()->withErrors([
                'code' => 'No existe un codigo activo para este correo. Solicita uno nuevo.',
            ])->withInput();
        }

        $createdAt = Carbon::parse($tokenRecord->created_at);

        if ($createdAt->addMinutes(self::CODE_TTL_MINUTES)->isPast()) {
            DB::table('password_reset_tokens')->where('email', $email)->delete();

            return redirect()
                ->route('contrasena.olvidada')
                ->with('error', 'El codigo expiro. Solicita uno nuevo para continuar.');
        }

        if (! Hash::check($code, (string) $tokenRecord->token)) {
            return back()->withErrors([
                'code' => 'El codigo ingresado no es correcto.',
            ])->withInput();
        }

        $request->session()->put('password_reset_verified_email', $email);
        $request->session()->put('password_reset_verified_at', now()->timestamp);

        return redirect()
            ->route('contrasena.nueva.formulario')
            ->with('success', 'Codigo validado correctamente. Ahora puedes definir tu nueva contrasena.');
    }

    /**
     * Mostrar pantalla para definir nueva contrasena despues de verificar codigo.
     */
    public function mostrarFormularioNuevaContrasena(Request $request): View|RedirectResponse
    {
        $email = (string) $request->session()->get('password_reset_verified_email', '');
        $verifiedAt = (int) $request->session()->get('password_reset_verified_at', 0);

        if ($email === '' || $verifiedAt <= 0) {
            return redirect()
                ->route('contrasena.olvidada')
                ->with('error', 'Debes validar el codigo antes de cambiar la contrasena.');
        }

        if (Carbon::createFromTimestamp($verifiedAt)->addMinutes(self::VERIFIED_TTL_MINUTES)->isPast()) {
            $request->session()->forget([
                'password_reset_email',
                'password_reset_verified_email',
                'password_reset_verified_at',
            ]);

            return redirect()
                ->route('contrasena.olvidada')
                ->with('error', 'La validacion expiro. Solicita un nuevo codigo de recuperacion.');
        }

        return view('auth.actualizar-contrasena', [
            'email' => $email,
        ]);
    }

    /**
     * Actualizar contrasena del usuario y redirigir al login.
     */
    public function actualizarContrasena(ActualizarContrasenaConCodigoRequest $request): RedirectResponse
    {
        $email = (string) $request->session()->get('password_reset_verified_email', '');
        $verifiedAt = (int) $request->session()->get('password_reset_verified_at', 0);

        if ($email === '' || $verifiedAt <= 0) {
            return redirect()
                ->route('contrasena.olvidada')
                ->with('error', 'La sesion de recuperacion no es valida. Solicita un nuevo codigo.');
        }

        if (Carbon::createFromTimestamp($verifiedAt)->addMinutes(self::VERIFIED_TTL_MINUTES)->isPast()) {
            $request->session()->forget([
                'password_reset_email',
                'password_reset_verified_email',
                'password_reset_verified_at',
            ]);

            return redirect()
                ->route('contrasena.olvidada')
                ->with('error', 'La validacion expiro. Solicita un nuevo codigo de recuperacion.');
        }

        $user = User::query()->where('email', $email)->first();

        if (! $user instanceof User) {
            return redirect()
                ->route('contrasena.olvidada')
                ->with('error', 'No encontramos una cuenta asociada para actualizar la contrasena.');
        }

        $user->update([
            'password' => (string) $request->validated('password'),
        ]);

        DB::table('password_reset_tokens')->where('email', $email)->delete();

        $request->session()->forget([
            'password_reset_email',
            'password_reset_verified_email',
            'password_reset_verified_at',
        ]);

        return redirect()
            ->route('login')
            ->with('success', 'Contrasena actualizada correctamente. Ya puedes iniciar sesion con la nueva clave.');
    }
}
