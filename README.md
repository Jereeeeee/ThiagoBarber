# Thiago Barber Web

Sitio web de Thiago Barber desarrollado con Laravel + Vite.

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
- Vite

## Instalacion local

1. Clonar el repositorio.
2. Instalar dependencias de PHP:

```bash
composer install
```

3. Instalar dependencias de Node:

```bash
npm install
```

4. Crear archivo de entorno:

```bash
copy .env.example .env
```

5. Generar key de la aplicacion:

```bash
php artisan key:generate
```

6. Levantar servidor Laravel:

```bash
php artisan serve
```

7. En otra terminal, ejecutar Vite en modo desarrollo:

```bash
npm run dev
```

## Build de produccion

```bash
npm run build
```

## Personalizacion rapida

- Reemplazar imagenes placeholder en `public/images/`.
- Actualizar textos y enlaces en las vistas Blade.
- Ajustar estilos en CSS segun branding.
- Cambiar/actualizar IDs de videos TikTok en la seccion correspondiente.

## Autor

Proyecto web para Thiago Barber.
