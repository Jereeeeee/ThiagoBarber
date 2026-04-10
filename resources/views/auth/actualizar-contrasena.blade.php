@extends('layouts.site')

@section('title', 'Nueva contrasena | Thiago Barber')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endpush

@section('content')
    <main class="auth-page">
        <section class="auth-card">
            <a class="auth-logo" href="{{ route('home') }}" aria-label="Volver a inicio">
                <img src="{{ asset('images/icon.svg') }}" alt="Logo Thiago Barber">
            </a>

            <h1>Cambiar contraseña</h1>
            <p class="auth-text">Define tu nueva contraseña para la cuenta <strong>{{ $email }}</strong>.</p>

            @if (session('error'))
                <div class="auth-alert" role="alert">{{ session('error') }}</div>
            @endif

            @if ($errors->any())
                <div class="auth-alert" role="alert">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('contrasena.nueva.guardar') }}" class="auth-form" novalidate>
                @csrf

                <label for="password">Nueva contraseña</label>
                <input id="password" name="password" type="password" autocomplete="new-password" required>

                <label for="password_confirmation">Confirmar nueva contraseña</label>
                <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required>

                <button type="submit" class="btn-primary">Guardar nueva contraseña</button>
            </form>

            <a class="auth-back" href="{{ route('login') }}">Volver al inicio de sesion</a>
        </section>
    </main>
@endsection
