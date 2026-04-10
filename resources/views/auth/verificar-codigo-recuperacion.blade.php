@extends('layouts.site')

@section('title', 'Verificar codigo | Thiago Barber')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endpush

@section('content')
    <main class="auth-page">
        <section class="auth-card">
            <a class="auth-logo" href="{{ route('home') }}" aria-label="Volver a inicio">
                <img src="{{ asset('images/icon.svg') }}" alt="Logo Thiago Barber">
            </a>

            <h1>Validar codigo</h1>
            <p class="auth-text">Ingresa el codigo de 6 digitos que enviamos a <strong>{{ $email }}</strong>.</p>

            @if (session('success'))
                <div class="auth-alert" role="alert">{{ session('success') }}</div>
            @endif

            @if (session('error'))
                <div class="auth-alert" role="alert">{{ session('error') }}</div>
            @endif

            @if ($errors->any())
                <div class="auth-alert" role="alert">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('contrasena.codigo.verificar') }}" class="auth-form" novalidate>
                @csrf
                <input type="hidden" name="email" value="{{ old('email', $email) }}">

                <label for="code">Codigo de verificacion</label>
                <input id="code" name="code" type="text" value="{{ old('code') }}" inputmode="numeric" maxlength="6" pattern="[0-9]{6}" required>

                <button type="submit" class="btn-primary">Validar codigo</button>
            </form>

            <a class="auth-back" href="{{ route('contrasena.olvidada') }}">Usar otro correo</a>
        </section>
    </main>
@endsection
