# Thiago Barber - Plataforma Web

<p align="center">
	<img src="public/images/icon.svg" alt="Logo Thiago Barber" width="140">
</p>

Proyecto web desarrollado para una barberia de Quilicura que necesitaba mostrar su marca y vender cursos online de barberia de forma clara, moderna y mantenible.

## Contexto del proyecto

La necesidad del negocio fue crear una presencia digital que permitiera:

- Mostrar servicios de barberia (cortes y productos).
- Comunicar la identidad de marca.
- Captar clientes por WhatsApp.
- Publicar y vender cursos de barberia online.

El desarrollo se enfoco en una base Laravel ordenada, con separacion de responsabilidades y vistas reutilizables para facilitar mantenimiento y escalabilidad.

## Objetivo principal

Construir una plataforma web para:

- Promocion de la barberia.
- Navegacion por secciones publicas (Home, Cortes, Cursos, Productos).
- Gestion basica de autenticacion (login/registro).
- Preparacion de la estructura para compra y seguimiento de cursos online.

## Tecnologias utilizadas

- PHP 8+
- Laravel 11+
- Blade Templates
- CSS y JavaScript (frontend)
- MySQL (o motor compatible con Laravel)
- Composer

## Estructura del proyecto

La aplicacion sigue la estructura estandar de Laravel, organizada por capas.

### Raiz

- `artisan`: comando CLI de Laravel.
- `composer.json`: dependencias PHP y scripts del proyecto.
- `phpunit.xml`: configuracion de pruebas.
- `Dockerfile`: base para ejecucion en contenedor.

### app/

Contiene la logica de negocio y HTTP.

- `app/Http/Controllers/`: controladores de autenticacion y paginas.
- `app/Http/Requests/`: validaciones desacopladas mediante Form Requests.
- `app/Models/`: modelos Eloquent (usuarios, cursos, etc.).
- `app/Providers/`: configuracion global y proveedores personalizados.

### bootstrap/

- Carga inicial de la aplicacion y registro de providers.

### config/

- Configuracion del framework (app, auth, cache, db, mail, session, etc.).

### database/

- `migrations/`: versionado del esquema de base de datos.
- `factories/`: datos de prueba.
- `seeders/`: carga inicial de datos.

### public/

Archivos publicos y punto de entrada web.

- `index.php`: front controller.
- `css/`, `js/`, `images/`, `videos/`: recursos estaticos del sitio.

### resources/

Recursos editables del frontend.

- `resources/views/`: vistas Blade (home, cortes, cursos, productos, auth, layout y partials).
- `resources/css/`, `resources/js/`: recursos fuente.

### routes/

- `web.php`: rutas web principales.
- `console.php`: rutas/comandos de consola.

### storage/

- Logs, cache compilada y archivos temporales de la aplicacion.

### tests/

- Pruebas Unit y Feature.

## Que se realizo en el proyecto

Durante el desarrollo se implemento una base enfocada en buenas practicas:

- Organizacion de rutas publicas en controlador dedicado para evitar logica dispersa.
- Extraccion de validaciones de autenticacion a Form Requests.
- Separacion de configuraciones sensibles (como rate limiting) en provider dedicado.
- Unificacion de vistas con un layout compartido para reducir duplicacion.
- Creacion de partials reutilizables para navbar y estructura visual.
- Ajustes responsive para navegacion en moviles.
- Integracion de acceso directo a contacto por WhatsApp.


## Puesta en marcha local

1. Instalar dependencias PHP:

```bash
composer install
```

2. Configurar entorno:

```bash
copy .env.example .env
php artisan key:generate
```

3. Configurar base de datos en `.env`.

4. Ejecutar migraciones:

```bash
php artisan migrate
```

5. Levantar servidor local:

```bash
php artisan serve
```

## Autores

- Gustavo Paredes | Desarrollador Web Junior | Ingeniero en Informatica
- Jeremy contrras | Desarrollador Web Junior | Ingeniero en Informatica

