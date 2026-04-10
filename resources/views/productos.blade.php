@extends('layouts.site')

@section('title', 'Productos | Thiago Barber')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/productos.css') }}">
@endpush

@section('content')
    @include('partials.catalog-navbar')

<main
    class="products-page"
    data-productos-page
    data-productos-config="{{ json_encode([
        'routeTemplates' => [
            'update' => route('productos.update', ['producto' => '__ID__']),
            'destroy' => route('productos.destroy', ['producto' => '__ID__']),
        ],
        'placeholderImage' => asset('images/placeholder-card.svg'),
        'shouldOpenStoreModal' => (bool) ($administradores && $errors->storeProducto->any()),
        'shouldOpenUpdateModal' => (bool) ($administradores && $errors->updateProducto->any()),
        'oldProductoId' => (string) old('producto_id', ''),
    ], JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) }}"
>
        <section class="container intro">
            <p class="kicker">Cuidado y estilo diario</p>
            <h1>Productos Disponibles</h1>
            <p>
                Seleccionamos productos profesionales para peinar, hidratar y mantener tu look de barberia.
                Administra este catalogo desde aqui para agregar, editar o eliminar productos cuando quieras.
            </p>
            @if ($administradores)
                <div class="intro-actions">
                    <button class="catalog-button" type="button" data-open-producto-modal>Agregar Nuevo Producto</button>
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

        <section class="container products-grid" aria-label="Catalogo de productos disponibles">
            @forelse ($productos as $producto)
                @php
                    $productoImageSrc = str_starts_with($producto->imagen_path, 'data:image')
                        ? $producto->imagen_path
                        : asset($producto->imagen_path);
                @endphp
                <article class="product-card">
                    @if ($administradores)
                        <div class="card-actions" aria-label="Acciones de tarjeta">
                            <button
                                type="button"
                                class="card-icon-button"
                                data-open-edit-modal
                                data-producto-id="{{ $producto->id }}"
                                data-producto-title="{{ $producto->titulo }}"
                                data-producto-description="{{ $producto->descripcion }}"
                                data-producto-badge="{{ $producto->etiqueta }}"
                                data-producto-price="{{ $producto->precio }}"
                                data-producto-image="{{ $productoImageSrc }}"
                                aria-label="Editar tarjeta {{ $producto->titulo }}"
                                title="Editar tarjeta"
                            >
                                &#9998;
                            </button>
                            <button
                                type="button"
                                class="card-icon-button danger"
                                data-open-delete-modal
                                data-producto-id="{{ $producto->id }}"
                                data-producto-title="{{ $producto->titulo }}"
                                aria-label="Eliminar tarjeta {{ $producto->titulo }}"
                                title="Eliminar tarjeta"
                            >
                                &times;
                            </button>
                        </div>
                    @endif

                    <img src="{{ $productoImageSrc }}" alt="{{ $producto->titulo }}">
                    <h2>{{ $producto->titulo }}</h2>
                    <p>{{ $producto->descripcion }}</p>
                    <div class="product-meta">
                        <span class="badge">{{ $producto->etiqueta }}</span>
                        <p class="price">${{ number_format($producto->precio, 0, ',', '.') }}</p>
                    </div>
                </article>
            @empty
                <article class="empty-state">
                    <h2>No hay productos disponibles</h2>
                    <p>Agrega el primer producto usando el boton superior.</p>
                </article>
            @endforelse
        </section>
    </main>

    @if ($administradores)
        @include('admin.productos.partials.admin-modals', ['submissionToken' => $submissionToken])
    @endif
@endsection

@push('scripts')
    <script src="{{ asset('js/productos.js') }}" defer></script>
@endpush
