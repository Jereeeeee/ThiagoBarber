@extends('layouts.site')

@section('title', 'Recuperar contraseña | Thiago Barber')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endpush

@section('content')
    <main class="auth-page">
        <section class="auth-card">
            <a class="auth-logo" href="{{ route('home') }}" aria-label="Volver a inicio">
                <img src="{{ asset('images/icon.svg') }}" alt="Logo Thiago Barber">
            </a>

            <h1>Recuperar contraseña</h1>
            <p class="auth-text">Ingresa el correo asociado a tu cuenta para enviarte un codigo de verificacion.</p>

            @if (session('error'))
                <div class="auth-alert" role="alert">{{ session('error') }}</div>
            @endif

            @if ($errors->any())
                <div class="auth-alert" role="alert">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('contrasena.olvidada.enviar_codigo') }}" class="auth-form" novalidate>
                @csrf

                <label for="email">Correo</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="email" required>

                <button type="submit" class="btn-primary">Enviar codigo</button>
            </form>

            <a class="auth-back" href="{{ route('login') }}">Volver al inicio de sesion</a>
        </section>
    </main>
@endsection
