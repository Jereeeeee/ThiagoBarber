<header class="topbar">
    <div class="container nav" data-nav-root>
        <a class="brand" href="{{ route('home') }}" aria-label="Inicio Thiago Barber">
            <img class="brand-logo" src="{{ asset('images/icon.png') }}" alt="Logo Thiago Barber">
        </a>

        <button
            type="button"
            class="nav-toggle"
            aria-label="Abrir menu"
            aria-expanded="false"
            aria-controls="menu-catalogo-movil"
            data-nav-toggle>
            <img src="{{ asset('images/barra-de-menus.png') }}" alt="Menu">
        </button>

        <a class="back-link" href="{{ route('home') }}">Volver al inicio</a>

        <nav class="catalog-mobile-menu" id="menu-catalogo-movil" data-nav-panel hidden aria-label="Menu movil de navegacion">
            <ul class="catalog-mobile-links">
                <li><a href="{{ route('home') }}">Inicio</a></li>
                <li><a href="{{ route('cortes') }}">Cortes</a></li>
                <li><a href="{{ route('cursos') }}">Cursos</a></li>
                <li><a href="{{ route('productos') }}">Productos</a></li>
                @auth
                    <li><a href="{{ route('account') }}">Cuenta</a></li>
                @else
                    <li><a href="{{ route('login') }}">Inicio de sesion</a></li>
                @endauth
            </ul>
        </nav>
    </div>
</header>

@push('scripts')
    <script src="{{ asset('js/navbar.js') }}" defer></script>
@endpush
