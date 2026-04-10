@extends('layouts.site')

@section('title', 'Cortes de Pelo | Thiago Barber')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/cortes.css') }}">
@endpush

@section('content')
    @include('partials.catalog-navbar')

    <main
        class="gallery-page"
        data-cortes-page
        data-cortes-config="{{ json_encode([
            "routeTemplates" => [
                "update" => route("cortes.update", ["corte" => "__ID__"]),
                "destroy" => route("cortes.destroy", ["corte" => "__ID__"]),
            ],
            "placeholderImage" => asset("images/placeholder-card.svg"),
            "shouldOpenStoreModal" => $administradores && $errors->storeCorte->any(),
            "shouldOpenUpdateModal" => $administradores && $errors->updateCorte->any(),
            "oldCorteId" => (string) old("corte_id", ""),
        ], JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) }}"
    >
        <section class="container intro">
            <p class="kicker">Catalogo de estilos</p>
            <h1>Cortes de Pelo</h1>
            <p>
                Esta vista esta dedicada solo a cortes. Puedes reemplazar cada imagen por tus fotos reales
                cuando las tengas listas y mantener el mismo orden del catalogo.
            </p>
            @if ($administradores)
                <div class="intro-actions">
                    <button class="catalog-button" type="button" data-open-corte-modal>Agregar Nuevo Corte</button>
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

        <section class="container cuts-grid" aria-label="Galeria de cortes de pelo">
            @forelse ($cortes as $corte)
                <article class="cut-card">
                    @if ($administradores)
                        <div class="card-actions" aria-label="Acciones de tarjeta">
                            <button
                                type="button"
                                class="card-icon-button"
                                data-open-edit-modal
                                data-corte-id="{{ $corte->id }}"
                                data-corte-title="{{ $corte->titulo }}"
                                data-corte-image="{{ asset($corte->imagen_path) }}"
                                aria-label="Editar tarjeta {{ $corte->titulo }}"
                                title="Editar tarjeta"
                            >
                                &#9998;
                            </button>
                            <button
                                type="button"
                                class="card-icon-button danger"
                                data-open-delete-modal
                                data-corte-id="{{ $corte->id }}"
                                data-corte-title="{{ $corte->titulo }}"
                                aria-label="Eliminar tarjeta {{ $corte->titulo }}"
                                title="Eliminar tarjeta"
                            >
                                &times;
                            </button>
                        </div>
                    @endif

                    <img src="{{ asset($corte->imagen_path) }}" alt="{{ $corte->titulo }}">
                    <h2>{{ $corte->titulo }}</h2>
                </article>
            @empty
                <article class="empty-state">
                    <h2>Aun no hay cortes registrados</h2>
                    <p>Agrega el primer corte usando el boton superior.</p>
                </article>
            @endforelse
        </section>
    </main>

    @if ($administradores)
        @include('admin.cortes.partials.admin-modals', ['submissionToken' => $submissionToken])
    @endif
@endsection

@push('scripts')
    <script src="{{ asset('js/cortes.js') }}" defer></script>
@endpush
