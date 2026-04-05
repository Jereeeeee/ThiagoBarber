<?php

namespace App\Http\Controllers;

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
        return view('home');
    }

    /**
     * Mostrar el catalogo de cortes.
     *
     * @return View
     */
    public function cortes(): View
    {
        return view('cortes');
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
