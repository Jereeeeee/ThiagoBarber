@extends('layouts.site')

@section('title', 'Productos | Thiago Barber')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/productos.css') }}">
@endpush

@section('content')
    @include('partials.catalog-navbar')

    <main class="products-page">
        <section class="container intro">
            <p class="kicker">Cuidado y estilo diario</p>
            <h1>Productos Disponibles</h1>
            <p>
                Seleccionamos productos profesionales para peinar, hidratar y mantener tu look de barberia.
                Puedes consultar stock y recomendaciones segun tu tipo de cabello.
            </p>
        </section>

        <section class="container products-grid" aria-label="Catalogo de productos disponibles">
            <article class="product-card">
                <img src="{{ asset('images/placeholder-card.svg') }}" alt="Cera mate de barberia">
                <h2>Cera Mate</h2>
                <p>Textura natural con fijacion media para peinados con volumen y acabado sin brillo.</p>
                <div class="product-meta">
                    <span class="badge">Stock Disponible</span>
                    <p class="price">$8.990</p>
                </div>
            </article>

            <article class="product-card">
                <img src="{{ asset('images/placeholder-card.svg') }}" alt="Pomada clasica de barberia">
                <h2>Pomada Clasica</h2>
                <p>Brillo controlado y fijacion firme para estilos clasicos de larga duracion.</p>
                <div class="product-meta">
                    <span class="badge">Top Ventas</span>
                    <p class="price">$9.990</p>
                </div>
            </article>

            <article class="product-card">
                <img src="{{ asset('images/placeholder-card.svg') }}" alt="Polvo texturizante para cabello">
                <h2>Polvo Texturizante</h2>
                <p>Volumen instantaneo con efecto mate para cabello fino o peinados desordenados.</p>
                <div class="product-meta">
                    <span class="badge">Nuevo Ingreso</span>
                    <p class="price">$10.500</p>
                </div>
            </article>

            <article class="product-card">
                <img src="{{ asset('images/placeholder-card.svg') }}" alt="Crema de peinado profesional">
                <h2>Crema de Peinado</h2>
                <p>Control suave e hidratacion para un acabado natural y sin rigidez.</p>
                <div class="product-meta">
                    <span class="badge">Recomendado</span>
                    <p class="price">$7.990</p>
                </div>
            </article>

            <article class="product-card">
                <img src="{{ asset('images/placeholder-card.svg') }}" alt="Aceite para barba premium">
                <h2>Aceite para Barba</h2>
                <p>Suaviza, hidrata y aporta brillo saludable para una barba mas ordenada.</p>
                <div class="product-meta">
                    <span class="badge">Stock Disponible</span>
                    <p class="price">$11.990</p>
                </div>
            </article>

            <article class="product-card">
                <img src="{{ asset('images/placeholder-card.svg') }}" alt="Shampoo profesional para barberia">
                <h2>Shampoo Barber Pro</h2>
                <p>Limpieza profunda para uso frecuente, pensado para cuero cabelludo y barba.</p>
                <div class="product-meta">
                    <span class="badge">Cupo Limitado</span>
                    <p class="price">$12.990</p>
                </div>
            </article>
        </section>
    </main>
@endsection
