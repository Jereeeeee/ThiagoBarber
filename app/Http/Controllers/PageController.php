<?php

namespace App\Http\Controllers;

use App\Models\Corte;
use App\Models\Producto;
use Illuminate\View\View;

class PageController extends Controller
{
    /**
     * Mostrar la pagina principal.
     *
     * @return View
     */
    public function home(): View
    {
        return view('home', [
            'cortes' => Corte::query()->latest()->limit(3)->get(),
            'productos' => Producto::query()->latest()->limit(3)->get(),
        ]);
    }

    /**
     * Mostrar el catalogo de cursos.
     *
     * @return View
     */
    public function cursos(): View
    {
        return view('cursos');
    }

    /**
     * Mostrar el catalogo de productos.
     *
     * @return View
     */
    public function productos(): View
    {
        return view('productos');
    }
}
