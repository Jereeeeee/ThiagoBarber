@extends('layouts.site')

@section('title', 'Cortes de Pelo | Thiago Barber')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/cortes.css') }}">
@endpush

@section('content')
    @include('partials.catalog-navbar')

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
@endsection
