@extends('layouts.site')

@section('title', 'Cursos | Thiago Barber')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/cursos.css') }}">
@endpush

@section('content')
    @include('partials.catalog-navbar')

    <main
        class="courses-page"
        data-cursos-page
        data-cursos-config="{{ json_encode([
            "routeTemplates" => [
                "update" => route("cursos.update", ["curso" => "__ID__"]),
                "destroy" => route("cursos.destroy", ["curso" => "__ID__"]),
            ],
            "placeholderImage" => asset("images/placeholder-card.svg"),
            "shouldOpenStoreModal" => $administradores && $errors->storeCurso->any(),
            "shouldOpenUpdateModal" => $administradores && $errors->updateCurso->any(),
            "oldCursoId" => (string) old("curso_id", ""),
        ], JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) }}"
    >
        <section class="container intro">
            <p class="kicker">Formacion profesional</p>
            <h1>Cursos Disponibles</h1>
            <p>
                Descubre todos los cursos de barberia disponibles para potenciar tu tecnica y avanzar al siguiente nivel.
            </p>

            @if ($administradores)
                <div class="intro-actions">
                    <button class="catalog-button" type="button" data-open-curso-modal>Agregar Nuevo Curso</button>
                </div>
            @endif
        </section>

        @if (session('success'))
            <section class="container success-banner" role="status" aria-live="polite">
                {{ session('success') }}
            </section>
        @endif

        @if (session('error'))
            <section class="container error-banner" role="alert" aria-live="assertive">
                {{ session('error') }}
            </section>
        @endif

        <section class="container courses-grid" aria-label="Listado de cursos disponibles">
            @forelse ($cursos as $curso)
                <article class="course-card">
                    @if ($administradores)
                        <div class="card-actions" aria-label="Acciones de tarjeta">
                            <button
                                type="button"
                                class="card-icon-button"
                                data-open-edit-modal
                                data-curso-id="{{ $curso->id }}"
                                data-curso-titulo="{{ $curso->titulo }}"
                                data-curso-descripcion="{{ $curso->descripcion }}"
                                data-curso-precio="{{ (int) $curso->precio }}"
                                data-curso-activo="{{ $curso->is_active ? '1' : '0' }}"
                                data-curso-image="{{ asset($curso->imagen_path ?: 'images/placeholder-card.svg') }}"
                                aria-label="Editar tarjeta {{ $curso->titulo }}"
                                title="Editar tarjeta"
                            >
                                &#9998;
                            </button>
                            <button
                                type="button"
                                class="card-icon-button danger"
                                data-open-delete-modal
                                data-curso-id="{{ $curso->id }}"
                                data-curso-titulo="{{ $curso->titulo }}"
                                aria-label="Eliminar tarjeta {{ $curso->titulo }}"
                                title="Eliminar tarjeta"
                            >
                                &times;
                            </button>
                        </div>
                    @endif

                    <img src="{{ asset($curso->imagen_path ?: 'images/placeholder-card.svg') }}" alt="Curso {{ $curso->titulo }}">
                    <h2>{{ $curso->titulo }}</h2>
                    <p>{{ $curso->descripcion }}</p>
                    <p class="price">Desde ${{ number_format((int) $curso->precio, 0, ',', '.') }}</p>
                    <span class="badge">{{ $curso->is_active ? 'Disponible' : 'No disponible' }}</span>

                    @if ($curso->is_active)
                        <div class="intro-actions">
                            <a
                                class="catalog-button"
                                href="https://api.whatsapp.com/send?phone=56935011486&text={{ $whatsappReserveMessage }}"
                                target="_blank"
                                rel="noopener noreferrer"
                            >
                                Reservar Curso
                            </a>
                        </div>
                    @endif
                </article>
            @empty
                <article class="empty-state">
                    <h2>Aun no hay cursos registrados</h2>
                    <p>Agrega el primer curso usando el boton superior.</p>
                </article>
            @endforelse
        </section>
    </main>

    @if ($administradores)
        @include('admin.cursos.partials.admin-modals', ['submissionToken' => $submissionToken])
    @endif
@endsection

@push('scripts')
    <script src="{{ asset('js/cursos.js') }}" defer></script>
@endpush
