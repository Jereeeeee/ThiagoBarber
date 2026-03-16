# Thiago Barber Web

Sitio web de Thiago Barber desarrollado con Laravel y assets estaticos en public.

La pagina incluye una portada comercial con enfoque visual, videos de TikTok, secciones de servicios/productos/contacto, una vista dedicada de cortes y una vista dedicada de cursos.

## Caracteristicas principales

- Landing page personalizada para barberia.
- Seccion de TikTok con videos embebidos.
- Carrusel movil para tarjetas (servicios, productos y TikTok) con indicadores.
- Google Maps embebido en la seccion de horario/ubicacion.
- Seccion de cursos con banner y boton de navegacion.
- Vista separada de cortes (`/cortes`).
- Vista separada de cursos (`/cursos`).

## Rutas

- `/` Inicio.
- `/cortes` Catalogo de cortes.
- `/cursos` Catalogo de cursos disponibles.

## Stack

- PHP / Laravel
- Blade
- CSS personalizado
- JavaScript (vanilla)
- Assets estaticos en `public/css`, `public/js` e `public/images`

## Instalacion local

1. Clonar el repositorio.
2. Instalar dependencias de PHP:

```bash
composer install
```

3. Crear archivo de entorno:

```bash
copy .env.example .env
```

4. Generar key de la aplicacion:

```bash
php artisan key:generate
```

5. Levantar servidor Laravel:

```bash
php artisan serve
```

No se requiere compilacion frontend. Los archivos CSS, JS e imagenes se sirven directamente desde `public/`.

## Personalizacion rapida

- Reemplazar imagenes placeholder en `public/images/`.
- Actualizar textos y enlaces en las vistas Blade.
- Ajustar estilos en CSS segun branding.
- Cambiar/actualizar IDs de videos TikTok en la seccion correspondiente.

## Autor

Proyecto web para Thiago Barber.
