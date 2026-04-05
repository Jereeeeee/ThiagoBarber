@extends('layouts.site')

@section('title', 'Cursos | Thiago Barber')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/cursos.css') }}">
@endpush

@section('content')
    @include('partials.catalog-navbar')

    <main class="courses-page">
        <section class="container intro">
            <p class="kicker">Formacion profesional</p>
            <h1>Cursos Disponibles</h1>
            <p>
                Aqui puedes ver todos los cursos de barberia disponibles. Las imagenes son referenciales
                y puedes reemplazarlas por tus fotos reales cuando quieras.
            </p>
        </section>

        <section class="container courses-grid" aria-label="Listado de cursos disponibles">
            <article class="course-card">
                <img src="{{ asset('images/placeholder-card.svg') }}" alt="Curso Inicial de barberia">
                <h2>Curso Inicial</h2>
                <p>Fundamentos de corte, uso de maquina, tijera y tecnica base para comenzar en barberia.</p>
                <span class="badge">Inscripciones Abiertas</span>
            </article>

            <article class="course-card">
                <img src="{{ asset('images/placeholder-card.svg') }}" alt="Curso Intermedio de barberia">
                <h2>Curso Intermedio</h2>
                <p>Perfeccionamiento de degradados, transiciones limpias y estilos modernos de alta demanda.</p>
                <span class="badge">Cupos Limitados</span>
            </article>

            <article class="course-card">
                <img src="{{ asset('images/placeholder-card.svg') }}" alt="Curso Master Barber">
                <h2>Master Barber</h2>
                <p>Entrenamiento avanzado con enfoque profesional para elevar tecnica, servicio y resultados.</p>
                <span class="badge">Proximo Inicio</span>
            </article>

            <article class="course-card">
                <img src="{{ asset('images/placeholder-card.svg') }}" alt="Curso de Barba Premium">
                <h2>Barba Premium</h2>
                <p>Diseño, perfilado, navaja y acabados premium para entregar un servicio completo de barba.</p>
                <span class="badge">Nuevas Fechas</span>
            </article>

            <article class="course-card">
                <img src="{{ asset('images/placeholder-card.svg') }}" alt="Curso de Color y Visos">
                <h2>Color y Visos</h2>
                <p>Tecnicas de coloracion para barberia y combinaciones modernas para estilos personalizados.</p>
                <span class="badge">Alta Demanda</span>
            </article>

            <article class="course-card">
                <img src="{{ asset('images/placeholder-card.svg') }}" alt="Curso de Marketing para Barberos">
                <h2>Marketing para Barberos</h2>
                <p>Estrategias de redes sociales, fidelizacion y ventas para escalar tu barberia.</p>
                <span class="badge">Nuevo</span>
            </article>
        </section>
    </main>
@endsection
