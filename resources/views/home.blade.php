<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Thiago Barber</title>
    <link rel="icon" type="image/png" href="{{ asset('images/icon.svg') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;700&family=Cormorant+Garamond:ital,wght@0,400;0,500;0,700;1,600&family=Manrope:wght@400;500;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    
</head>

<body>

    <header class="topbar">
        <div class="container nav">
            <ul class="nav-links nav-left">
                <li><a href="{{ route('cortes') }}">Cortes</a></li>
                <li><a href="{{ route('cursos') }}">Cursos</a></li>
            </ul>

            <div class="brand">Thiago <span>Barber</span><small>Since 2018</small></div>

            <ul class="nav-links nav-right">
                <li><a href="{{ route('productos') }}">Productos</a></li>
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
                    <a class="btn btn-secondary" href="{{ route('cursos') }}">Ver cursos disponibles</a>
                </div>
            </section>

            <aside class="hero-card">
                <h2>Horario y ubicación</h2>
                <p class="kicker">Encuéntranos en el corazón de Valle Grande en un espacio pensado exclusivamente para tu comodidad.</p>
                <ul class="meta">
                    <li>Lun - Sab<br><strong>10:00 - 20:00</strong></li>
                    <li>Domingos<br><strong>11:00 - 16:00</strong></li>
                    <li>Direccion<br><strong>Cam. del Sol 218, Valle Grande, Lampa</strong></li>
                    <li>Telefono<br><strong>+56 9 3501 1486</strong></li>
                </ul>
                <div class="map-embed" aria-label="Mapa de ubicación de Thiago Barber">
                    <iframe title="Ubicación Thiago Barber"
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d416.7322754173636!2d-70.74816247631527!3d-33.32252233400226!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x9662c15e0fc71799%3A0xc78d5e7a90c439b7!2sBarber%C3%ADa%20THIAGO%20BARBER!5e0!3m2!1ses!2sus!4v1774919567062!5m2!1ses!2sus"
                        width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade" width="600" height="450" style="border:0;"
                        allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade"
                        aria-label="Mapa con ubicación de Thiago Barber">
                    </iframe>
                </div>
            </aside>
        </div>
    </main>



<section id="videos" class="section">
    <div class="container">
        <h3 style="text-align: center; margin-bottom: 2rem;">Resultados en TikTok</h3>
        <div class="tiktok-grid">
            
            <!-- Video 1 -->
            <article class="card tiktok-card" style="position: relative;">
                <a href="https://www.tiktok.com/@thiagobarber31/video/7356809635464203526" target="_blank" rel="noopener" style="text-decoration: none; color: white;">
                    <video class="tiktok-frame" src="{{ asset('videos/7356809635464203526.mp4') }}" 
                        autoplay loop muted playsinline 
                        style="object-fit: cover; width: 100%; height: 100%; display: block; border-radius: 15px;">
                    </video>
                </a>
            </article>

            <!-- Video 2 -->
            <article class="card tiktok-card" style="position: relative;">
                <a href="https://www.tiktok.com/@thiagobarber31/video/7351215632354004230" target="_blank" rel="noopener" style="text-decoration: none; color: white;">
                    <video class="tiktok-frame" src="{{ asset('videos/7351215632354004230.mp4') }}" 
                        autoplay loop muted playsinline 
                        style="object-fit: cover; width: 100%; height: 100%; display: block; border-radius: 15px;">
                    </video>
                </a>
            </article>

            <!-- Video 3 -->
            <article class="card tiktok-card" style="position: relative;">
                <a href="https://www.tiktok.com/@thiagobarber31/video/7349362441823735045" target="_blank" rel="noopener" style="text-decoration: none; color: white;">
                    <video class="tiktok-frame" src="{{ asset('videos/7349362441823735045.mp4') }}" 
                        autoplay loop muted playsinline 
                        style="object-fit: cover; width: 100%; height: 100%; display: block; border-radius: 15px;">
                    </video>
                </a>
            </article>

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
            <div class="services">
                <article class="card">
                    <img class="card-image" src="{{ asset('images/placeholder-card.svg') }}" alt="Imagen de low fade">
                    <h4>Low Fade</h4>
                    <p>Degradado bajo con transicion limpia y acabado prolijo para un look moderno.</p>
                    <p class="price">Desde $12.000</p>
                </article>
                <article class="card">
                    <img class="card-image" src="{{ asset('images/placeholder-card.svg') }}" alt="Imagen de mid fade">
                    <h4>Mid Fade</h4>
                    <p>Fade a media altura con volumen arriba, ideal para estilos urbanos y versatiles.</p>
                    <p class="price">Desde $13.000</p>
                </article>
                <article class="card">
                    <img class="card-image" src="{{ asset('images/placeholder-card.svg') }}"
                        alt="Imagen de crop frances">
                    <h4>Crop Frances</h4>
                    <p>Corte corto texturizado con flequillo, comodo de mantener y con mucha actitud.</p>
                    <p class="price">Desde $14.000</p>
                </article>
            </div>
        </div>
    </section>

    <section id="estilo" class="section">
        <div class="container">
            <h3>Nuestros Productos</h3>
            <div class="products">
                <article class="card product-card">
                    <img class="card-image" src="{{ asset('images/placeholder-card.svg') }}"
                        alt="Imagen de cera para el cabello">
                    <h4>Ceras</h4>
                    <p>Fijacion flexible o fuerte para peinar y definir el estilo durante todo el dia.</p>
                </article>
                <article class="card product-card">
                    <img class="card-image" src="{{ asset('images/placeholder-card.svg') }}"
                        alt="Imagen de crema de peinado">
                    <h4>Cremas</h4>
                    <p>Acabado natural con hidratacion para controlar el volumen sin rigidez.</p>
                </article>
                <article class="card product-card">
                    <img class="card-image" src="{{ asset('images/placeholder-card.svg') }}"
                        alt="Imagen de polvo texturizante">
                    <h4>Polvos</h4>
                    <p>Textura instantanea y efecto mate para dar cuerpo y movimiento al cabello.</p>
                </article>
                <article class="card product-card">
                    <img class="card-image" src="{{ asset('images/placeholder-card.svg') }}"
                        alt="Imagen de pomada para cabello">
                    <h4>Pomadas</h4>
                    <p>Brillo y control para peinados clasicos con terminacion prolija.</p>
                </article>
            </div>
            <div class="courses-cta">
                <a class="btn btn-primary" href="{{ route('productos') }}">Ver catalogo de productos</a>
            </div>
        </div>
    </section>

    <section id="contacto" class="section">
        <div class="container contact">
            <h3>Reserva Tu nuevo corte!</h3>
            <p>Escribenos por WhatsApp o llamanos para rerservar en Thiago Barber.</p>
            <a class="btn btn-primary" href="https://wa.me/56935011486" target="_blank" rel="noopener noreferrer">Ir a
                WhatsApp</a>
        </div>
    </section>

    <footer class="footer">
        <div class="container footer-content">
            <p class="footer-title">Redes Sociales</p>
            <div class="footer-socials">
                <a href="https://www.instagram.com/thiagobarber31/" target="_blank"
                    rel="noopener noreferrer">Instagram</a>
                <a href="https://www.tiktok.com/@thiagobarber31" target="_blank" rel="noopener noreferrer">TikTok</a>
            </div>
            <p class="footer-copy">Thiago Barber.</p>
        </div>
    </footer>
    <script src="{{ asset('js/home.js') }}" defer></script>
</body>

</html>