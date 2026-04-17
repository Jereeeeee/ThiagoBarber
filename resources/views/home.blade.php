@extends('layouts.site')

@section('title', 'Thiago Barber')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endpush

@section('content')
    @php
        $whatsappMessage = rawurlencode('Hola!! 👋 Quiero reservar una hora 💈');
    @endphp

    @include('partials.home-navbar')

    <main id="inicio" class="hero">
        <div class="container hero-grid">
            <section class="hero-copy">
                <p class="kicker">Barberia Premium en tu zona</p>
                <h1>CORTE FINO, ACTITUD FIRME.</h1>
                <p>
                    En Thiago Barber unimos tecnica clasica y estilo urbano para que salgas con un look limpio,
                    moderno y con personalidad. Cortes, barba y perfilado al detalle.
                </p>
                <div class="hero-cta">
                    <a class="btn btn-primary" href="{{ route('cortes') }}">Ver catalogo de cortes</a>
                    <a class="btn btn-secondary" href="{{ route('cursos') }}">Ver cursos disponibles</a>
                </div>
            </section>

            <aside class="hero-card">
                <h2>Horario y ubicación</h2>
                <p class="kicker">Encuéntranos en el corazón de Valle Grande en un espacio pensado exclusivamente para tu
                    comodidad.</p>
                <ul class="meta">
                    <li>Lun - Sab<br><strong>10:00 - 20:00</strong></li>
                    <li>Domingos<br><strong>11:00 - 16:00</strong></li>
                    <li>Direccion<br><strong>Cam. del Sol 218, Valle Grande, Lampa</strong></li>
                    <li>Telefono<br><strong>+56 9 3501 1486</strong></li>
                </ul>
                <div class="map-embed" aria-label="Mapa de ubicación de Thiago Barber">
                    <iframe title="Ubicación Thiago Barber"
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d416.7322754173636!2d-70.74816247631527!3d-33.32252233400226!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x9662c15e0fc71799%3A0xc78d5e7a90c439b7!2sBarber%C3%ADa%20THIAGO%20BARBER!5e0!3m2!1ses!2sus!4v1774919567062!5m2!1ses!2sus"
                        width="600" height="450" style="border:0;" allowfullscreen loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade" aria-label="Mapa con ubicación de Thiago Barber">
                    </iframe>
                </div>
            </aside>
        </div>
    </main>

    <section id="videos" class="section tiktok-section" data-tiktok-carousel>
        <div class="container">
            <h3 class="tiktok-title">Visita nuestro TikTok</h3>

            <div class="tiktok-shell" role="region" aria-label="Carrusel de videos de TikTok">
                <button class="tiktok-nav tiktok-nav-prev" type="button" aria-label="Video anterior">
                    <span aria-hidden="true">&larr;</span>
                </button>

                <div class="tiktok-track" data-tiktok-track>
                    <article class="tiktok-slide is-active" data-tiktok-slide>
                        <a class="tiktok-link" href="https://www.tiktok.com/@thiagobarber31/video/7356809635464203526" target="_blank"
                            rel="noopener noreferrer" aria-label="Ver video 1 en TikTok">
                            <video class="tiktok-video" src="{{ asset('videos/7356809635464203526.mp4') }}" muted loop playsinline
                                preload="metadata"></video>
                        </a>
                    </article>

                    <article class="tiktok-slide" data-tiktok-slide>
                        <a class="tiktok-link" href="https://www.tiktok.com/@thiagobarber31/video/7351215632354004230" target="_blank"
                            rel="noopener noreferrer" aria-label="Ver video 2 en TikTok">
                            <video class="tiktok-video" src="{{ asset('videos/7351215632354004230.mp4') }}" muted loop playsinline
                                preload="none"></video>
                        </a>
                    </article>

                    <article class="tiktok-slide" data-tiktok-slide>
                        <a class="tiktok-link" href="https://www.tiktok.com/@thiagobarber31/video/7349362441823735045" target="_blank"
                            rel="noopener noreferrer" aria-label="Ver video 3 en TikTok">
                            <video class="tiktok-video" src="{{ asset('videos/7349362441823735045.mp4') }}" muted loop playsinline
                                preload="none"></video>
                        </a>
                    </article>
                </div>

                <button class="tiktok-nav tiktok-nav-next" type="button" aria-label="Siguiente video">
                    <span aria-hidden="true">&rarr;</span>
                </button>
            </div>

            <div class="tiktok-dots" aria-label="Indicadores de videos">
                <button class="tiktok-dot is-active" type="button" data-tiktok-dot="0" aria-label="Ir al video 1"></button>
                <button class="tiktok-dot" type="button" data-tiktok-dot="1" aria-label="Ir al video 2"></button>
                <button class="tiktok-dot" type="button" data-tiktok-dot="2" aria-label="Ir al video 3"></button>
            </div>
        </div>
    </section>

    <section id="cursos" class="section">
        <div class="container">
            <h3>Cursos de Barberia</h3>
            <div class="courses">
                <article class="card courses-banner-card">
                    <img class="courses-banner-image" src="{{ asset('images/placeholder-card.svg') }}"
                        alt="Banner de cursos de barberia">
                </article>
            </div>
            <div class="courses-cta">
                <a class="btn btn-primary" href="{{ route('cursos') }}">Ver todos los cursos</a>
            </div>
        </div>
    </section>

    <section id="servicios" class="section">
        <div class="container">
            <h3>Cortes de Pelo</h3>
            <div class="services" data-mobile-carousel data-carousel-label="Cortes de pelo">
                @forelse ($cortes as $corte)
                    <article class="card">
                        <img class="card-image" src="{{ asset($corte->imagen_path) }}" alt="{{ $corte->titulo }}">
                        <h4>{{ $corte->titulo }}</h4>
                    </article>
                @empty
                    <article class="card">
                        <img class="card-image" src="{{ asset('images/placeholder-card.svg') }}" alt="Sin cortes disponibles">
                        <h4>Sin cortes disponibles</h4>
                    </article>
                @endforelse
            </div>
            <div class="carousel-dots" data-carousel-dots aria-label="Indicadores de cortes de pelo"></div>
            <div class="courses-cta">
                <a class="btn btn-primary" href="{{ route('cortes') }}">Ver mas</a>
            </div>
        </div>
    </section>

    <section id="estilo" class="section">
        <div class="container">
            <h3>Nuestros Productos</h3>
            <div class="products" data-mobile-carousel data-carousel-label="Productos disponibles">
                @forelse ($productos as $producto)
                    @php
                        $productoImageSrc = str_starts_with($producto->imagen_path, 'data:image')
                            ? $producto->imagen_path
                            : asset($producto->imagen_path);
                    @endphp
                    <article class="card product-card">
                        <img class="card-image" src="{{ $productoImageSrc }}" alt="{{ $producto->titulo }}">
                        <h4>{{ $producto->titulo }}</h4>
                        <p>{{ $producto->descripcion }}</p>
                    </article>
                @empty
                    <article class="card product-card">
                        <img class="card-image" src="{{ asset('images/placeholder-card.svg') }}" alt="Sin productos disponibles">
                        <h4>Sin productos disponibles</h4>
                    </article>
                @endforelse
            </div>
            <div class="carousel-dots" data-carousel-dots aria-label="Indicadores de productos"></div>
            <div class="courses-cta">
                <a class="btn btn-primary" href="{{ route('productos') }}">Ver mas</a>
            </div>
        </div>
    </section>

    <section id="contacto" class="section">
        <div class="container contact">
            <h3>Reserva Tu nuevo corte!</h3>
            <p>Escribenos por WhatsApp o llamanos para rerservar en Thiago Barber.</p>
            <a class="btn btn-primary" href="https://api.whatsapp.com/send?phone=56935011486&text={{ $whatsappMessage }}"
                target="_blank" rel="noopener noreferrer">Ir a WhatsApp</a>
        </div>
    </section>

    <footer class="footer">
        <div class="container footer-content">
            <p class="footer-title">Redes Sociales</p>
            <div class="footer-socials">
                <a href="https://www.instagram.com/thiagobarber31/" target="_blank" rel="noopener noreferrer">Instagram</a>
                <a href="https://www.tiktok.com/@thiagobarber31" target="_blank" rel="noopener noreferrer">TikTok</a>
            </div>
            <p class="footer-copy">Thiago Barber.</p>
        </div>
    </footer>

    <a class="whatsapp-float" href="https://api.whatsapp.com/send?phone=56935011486&text={{ $whatsappMessage }}"
        target="_blank" rel="noopener noreferrer" aria-label="Reservar por WhatsApp">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
            <path fill="currentColor"
                d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.1 0-65.6-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-5.5-2.8-23.2-8.5-44.2-27.1-16.4-14.6-27.4-32.7-30.6-38.2-3.2-5.6-.3-8.6 2.5-11.3 2.5-2.5 5.5-6.5 8.3-9.7 2.8-3.3 3.7-5.6 5.5-9.3 1.8-3.7.9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 13.2 5.7 23.5 9.2 31.6 11.8 13.3 4.2 25.4 3.6 35 2.2 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z" />
        </svg>
        <span>WhatsApp</span>
    </a>
@endsection

@push('scripts')
    <script src="{{ asset('js/home.js') }}" defer></script>
@endpush