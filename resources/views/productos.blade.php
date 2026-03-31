<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Productos | Thiago Barber</title>
        <link rel="icon" type="image/svg+xml" href="{{ asset('images/icon.svg') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;700&family=Cormorant+Garamond:ital,wght@0,400;0,500;0,700;1,600&family=Manrope:wght@400;500;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/productos.css') }}">
</head>
<body>
    <header class="topbar">
        <div class="container nav">
            <a class="brand" href="{{ route('home') }}" aria-label="Inicio Thiago Barber">
                <img class="brand-logo" src="{{ asset('images/icon.svg') }}" alt="Logo Thiago Barber">
            </a>
            <a class="back-link" href="{{ route('home') }}">Volver al inicio</a>
        </div>
    </header>

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
</body>
</html>
