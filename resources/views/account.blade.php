@extends('layouts.site')

@section('title', 'Cuenta | Thiago Barber')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endpush

@section('content')
    <main class="auth-page">
        <a class="auth-logo" href="{{ route('home') }}" aria-label="Volver a inicio">
            <img src="{{ asset('images/icon.svg') }}" alt="Logo Thiago Barber">
        </a>
        <h1 id="account-title">Hola, {{ $user->name }}</h1>
        <p class="auth-text">Tu sesion esta activa y lista para gestionar tu perfil y cursos.</p>

        <section class="account-section" aria-label="Informacion de cuenta">
            <h2 class="account-title">Informacion de cuenta</h2>
            <dl class="account-grid">
                <div class="account-item">
                    <dt>Nombre</dt>
                    <dd>{{ $user->name }}</dd>
                </div>
                <div class="account-item">
                    <dt>Correo</dt>
                    <dd>{{ $user->email }}</dd>
                </div>
                <div class="account-item">
                    <dt>Miembro desde</dt>
                    <dd>{{ optional($user->created_at)->format('d/m/Y') }}</dd>
                </div>
            </dl>
        </section>

        <section class="account-section" aria-label="Cursos comprados">
            <h2 class="account-title">Cursos comprados</h2>

            @if ($cursosComprados->isEmpty())
                <p class="account-empty">Aun no tienes cursos comprados.</p>
            @else
                <ul class="account-courses">
                    @foreach ($cursosComprados as $curso)
                        <li class="account-course">
                            <span class="account-course-title">{{ $curso->title }}</span>
                            @if (!empty($curso->level))
                                <span class="account-course-meta">Nivel: {{ $curso->level }}</span>
                            @endif
                        </li>
                    @endforeach
                </ul>
            @endif
        </section>

        <div class="auth-actions">
            <a class="btn-secondary" href="{{ route('home') }}">Ir al inicio</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-primary">Cerrar sesion</button>
            </form>
        </div>
    </main>
@endsection
