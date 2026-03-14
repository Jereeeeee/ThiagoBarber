<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cortes de Pelo | Thiago Barber</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Manrope:wght@400;500;700;800&display=swap" rel="stylesheet">
    @vite('resources/css/cortes.css')
</head>
<body>
    <header class="topbar">
        <div class="container nav">
            <a class="brand" href="{{ route('home') }}">Thiago <span>Barber</span></a>
            <a class="back-link" href="{{ route('home') }}">Volver al inicio</a>
        </div>
    </header>

    <main class="gallery-page">
        <section class="container intro">
            <p class="kicker">Catalogo de estilos</p>
            <h1>Cortes de Pelo</h1>
            <p>
                Esta vista esta dedicada solo a cortes. Puedes reemplazar cada imagen por tus fotos reales
                cuando las tengas listas y mantener el mismo orden del catalogo.
            </p>
        </section>

        <section class="container cuts-grid" aria-label="Galeria de cortes de pelo">
            <article class="cut-card">
                <img src="{{ asset('images/placeholder-card.svg') }}" alt="Corte Fade Clasico">
                <h2>Fade Clasico</h2>
            </article>
            <article class="cut-card">
                <img src="{{ asset('images/placeholder-card.svg') }}" alt="Corte Low Fade">
                <h2>Low Fade</h2>
            </article>
            <article class="cut-card">
                <img src="{{ asset('images/placeholder-card.svg') }}" alt="Corte Mid Fade">
                <h2>Mid Fade</h2>
            </article>
            <article class="cut-card">
                <img src="{{ asset('images/placeholder-card.svg') }}" alt="Corte High Fade">
                <h2>High Fade</h2>
            </article>
            <article class="cut-card">
                <img src="{{ asset('images/placeholder-card.svg') }}" alt="Corte Crop Texturizado">
                <h2>Crop Texturizado</h2>
            </article>
            <article class="cut-card">
                <img src="{{ asset('images/placeholder-card.svg') }}" alt="Corte Pompadour">
                <h2>Pompadour</h2>
            </article>
            <article class="cut-card">
                <img src="{{ asset('images/placeholder-card.svg') }}" alt="Corte Mullet Moderno">
                <h2>Mullet Moderno</h2>
            </article>
            <article class="cut-card">
                <img src="{{ asset('images/placeholder-card.svg') }}" alt="Corte Buzz Cut">
                <h2>Buzz Cut</h2>
            </article>
            <article class="cut-card">
                <img src="{{ asset('images/placeholder-card.svg') }}" alt="Corte Taper Fade">
                <h2>Taper Fade</h2>
            </article>
        </section>
    </main>
</body>
</html>
