<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Thiago Barber</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Manrope:wght@400;500;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/welcome.css', 'resources/js/welcome.js'])
</head>
<body>
    <header class="topbar">
        <div class="container nav">
            <ul class="nav-links nav-left">
                <li><a href="{{ route('cortes') }}">Cortes</a></li>
                <li><a href="#cursos">Cursos</a></li>
                <li><a href="#servicios">Servicios</a></li>
            </ul>

            <div class="brand">Thiago <span>Barber</span></div>

            <ul class="nav-links nav-right">
                <li><a href="#estilo">Productos</a></li>
                <li><a href="#contacto">Contacto</a></li>
            </ul>
        </div>
    </header>

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
                    <a class="btn btn-secondary" href="#cursos">Ver cursos disponibles</a>
                </div>
            </section>

            <aside class="hero-card">
                <h2>Horario y Ubicacion</h2>
                <ul class="meta">
                    <li>Lun - Sab<br><strong>10:00 - 20:00</strong></li>
                    <li>Domingos<br><strong>11:00 - 16:00</strong></li>
                    <li>Direccion<br><strong>Valle Grande, Lampa</strong></li>
                    <li>Telefono<br><strong>+56 9 3501 1486</strong></li>
                </ul>
                <div class="map-embed" aria-label="Mapa de ubicacion de Thiago Barber">
                    <iframe
                        title="Ubicacion Thiago Barber"
                        src="https://www.google.com/maps?q=Barber%C3%ADa%20THIAGO%20BARBER%20-33.3226246%2C-70.7481974&z=17&output=embed"
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        allowfullscreen>
                    </iframe>
                </div>
            </aside>
        </div>
    </main>

    <section id="videos" class="section">
        <div class="container">
            <h3>Videos en TikTok</h3>
            <div class="tiktok-grid">
                <article class="card tiktok-card">
                    <iframe
                        class="tiktok-frame"
                        src="https://www.tiktok.com/embed/v2/7356809635464203526"
                        title="Video TikTok 1"
                        loading="lazy"
                        allowfullscreen
                        scrolling="no">
                    </iframe>
                </article>

                <article class="card tiktok-card">
                    <iframe
                        class="tiktok-frame"
                        src="https://www.tiktok.com/embed/v2/7351215632354004230"
                        title="Video TikTok 2"
                        loading="lazy"
                        allowfullscreen
                        scrolling="no">
                    </iframe>
                </article>

                <article class="card tiktok-card">
                    <iframe
                        class="tiktok-frame"
                        src="https://www.tiktok.com/embed/v2/7349362441823735045"
                        title="Video TikTok 3"
                        loading="lazy"
                        allowfullscreen
                        scrolling="no">
                    </iframe>
                </article>
            </div>
        </div>
    </section>

    <section id="cursos" class="section">
        <div class="container">
            <h3>Cursos de Barberia</h3>
            <div class="courses">
                <article class="card courses-banner-card">
                    <img class="courses-banner-image" src="{{ asset('images/placeholder-card.svg') }}" alt="Banner de cursos de barberia">
                </article>
            </div>
            <div class="courses-cta">
                <a class="btn btn-primary" href="{{ route('cursos') }}">Ver todos los cursos</a>
            </div>
        </div>
    </section>

    <section id="servicios" class="section">
        <div class="container">
            <h3>Servicios</h3>
            <div class="services">
                <article class="card">
                    <img class="card-image" src="{{ asset('images/placeholder-card.svg') }}" alt="Imagen de corte clasico">
                    <h4>Corte Clasico</h4>
                    <p>Degradado, tijera y acabado profesional segun tu estilo.</p>
                    <p class="price">PRECIO</p>
                </article>
                <article class="card">
                    <img class="card-image" src="{{ asset('images/placeholder-card.svg') }}" alt="Imagen de barba premium">
                    <h4>Barba Premium</h4>
                    <p>Perfilado, toalla caliente y acabado con navaja.</p>
                    <p class="price">PRECIO</p>
                </article>
                <article class="card">
                    <img class="card-image" src="{{ asset('images/placeholder-card.svg') }}" alt="Imagen de combo total">
                    <h4>Combo Total</h4>
                    <p>Corte + barba + ceja para look completo y limpio.</p>
                    <p class="price">PRECIO</p>
                </article>
            </div>
        </div>
    </section>

    <section id="estilo" class="section">
        <div class="container">
            <h3>Nuestros Productos</h3>
            <div class="products">
                <article class="card product-card">
                    <img class="card-image" src="{{ asset('images/placeholder-card.svg') }}" alt="Imagen de cera para el cabello">
                    <h4>Ceras</h4>
                    <p>Fijacion flexible o fuerte para peinar y definir el estilo durante todo el dia.</p>
                </article>
                <article class="card product-card">
                    <img class="card-image" src="{{ asset('images/placeholder-card.svg') }}" alt="Imagen de crema de peinado">
                    <h4>Cremas</h4>
                    <p>Acabado natural con hidratacion para controlar el volumen sin rigidez.</p>
                </article>
                <article class="card product-card">
                    <img class="card-image" src="{{ asset('images/placeholder-card.svg') }}" alt="Imagen de polvo texturizante">
                    <h4>Polvos</h4>
                    <p>Textura instantanea y efecto mate para dar cuerpo y movimiento al cabello.</p>
                </article>
                <article class="card product-card">
                    <img class="card-image" src="{{ asset('images/placeholder-card.svg') }}" alt="Imagen de pomada para cabello">
                    <h4>Pomadas</h4>
                    <p>Brillo y control para peinados clasicos con terminacion prolija.</p>
                </article>
            </div>
        </div>
    </section>

    <section id="contacto" class="section">
        <div class="container contact">
            <h3>Reserva Tu Espacio</h3>
            <p>Escribenos por WhatsApp o llamanos para rerservar en Thiago Barber.</p>
            <a class="btn btn-primary" href="https://wa.me/56935011486" target="_blank" rel="noopener noreferrer">Ir a WhatsApp</a>
        </div>
    </section>

    <footer class="footer">
        <div class="container footer-content">
            <p class="footer-title">Redes Sociales</p>
            <div class="footer-socials">
                <a href="https://www.instagram.com/thiagobarber31/" target="_blank" rel="noopener noreferrer">Instagram</a>
                <a href="https://www.tiktok.com/@thiagobarber31" target="_blank" rel="noopener noreferrer">TikTok</a>
            </div>
            <p class="footer-copy">Thiago Barber - MENSAJE EDITABLE .</p>
        </div>
    </footer>
</body>
</html>
