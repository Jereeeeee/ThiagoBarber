@extends('layouts.site')

@section('title', 'Inicio de sesion | Thiago Barber')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endpush

@section('content')
    @php
        $activePanel = old('auth_mode', 'login');
        if ($errors->has('name') || $errors->has('password_confirmation')) {
            $activePanel = 'register';
        }
    @endphp

    <main class="auth-page">
        <section class="auth-card auth-card--switch" data-auth-root data-active-panel="{{ $activePanel }}">
            <a class="auth-logo" href="{{ route('home') }}" aria-label="Volver a inicio">
                <img src="{{ asset('images/icon.svg') }}" alt="Logo Thiago Barber">
            </a>

            <div class="auth-tabs" role="tablist" aria-label="Elegir formulario">
                <button type="button" class="auth-tab" data-auth-tab="login" role="tab" aria-selected="false">Iniciar sesion</button>
                <button type="button" class="auth-tab" data-auth-tab="register" role="tab" aria-selected="false">Crear cuenta</button>
            </div>

            <div class="auth-panels" data-auth-panels>
                <article class="auth-panel" data-auth-panel="login" aria-labelledby="auth-title-login">
                    <h1 id="auth-title-login">Inicio de sesion</h1>

                    @if ($errors->any() && $activePanel === 'login')
                        <div class="auth-alert" role="alert">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login.store') }}" class="auth-form" novalidate>
                        @csrf
                        <input type="hidden" name="auth_mode" value="login">

                        <label for="email">Correo</label>
                        <input id="email" name="email" type="email" value="{{ old('auth_mode') === 'login' ? old('email') : '' }}" autocomplete="username" required>

                        <label for="password">Contrasena</label>
                        <input id="password" name="password" type="password" autocomplete="current-password" required>

                        <label class="auth-check" for="remember">
                            <input id="remember" name="remember" type="checkbox" value="1" {{ old('remember') ? 'checked' : '' }}>
                            <span>Recordarme en este equipo</span>
                        </label>

                        <button type="submit" class="btn-primary">Entrar</button>
                    </form>
                </article>

                <article class="auth-panel" data-auth-panel="register" aria-labelledby="auth-title-register">
                    <h1 id="auth-title-register">Crear cuenta</h1>

                    @if ($errors->any() && $activePanel === 'register')
                        <div class="auth-alert" role="alert">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('register.store') }}" class="auth-form" novalidate>
                        @csrf
                        <input type="hidden" name="auth_mode" value="register">

                        <label for="name">Nombre completo</label>
                        <input id="name" name="name" type="text" value="{{ old('name') }}" autocomplete="name" required>

                        <label for="register-email">Correo</label>
                        <input id="register-email" name="email" type="email" value="{{ old('auth_mode') === 'register' ? old('email') : '' }}" autocomplete="email" required>

                        <label for="register-password">Contrasena</label>
                        <input id="register-password" name="password" type="password" autocomplete="new-password" required>

                        <label for="password_confirmation">Confirmar contrasena</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required>

                        <button type="submit" class="btn-primary">Crear cuenta</button>
                    </form>
                </article>
            </div>

            <a class="auth-back" href="{{ route('home') }}">Volver al inicio</a>
        </section>
    </main>
@endsection

@push('scripts')
    <script src="{{ asset('js/auth.js') }}" defer></script>
@endpush
