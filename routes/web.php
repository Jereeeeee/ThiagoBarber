<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\CorteController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\Auth\RecuperarContrasenaController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductoController;
use Illuminate\Support\Facades\Route;

Route::get('/up', function () {
    return response('OK', 200);
});

Route::controller(PageController::class)->group(function () {
    Route::get('/', 'home')->name('home');
});

Route::get('/cursos', [CursoController::class, 'index'])->name('cursos');
Route::middleware('catalog.admin')->group(function () {
    Route::post('/cursos', [CursoController::class, 'store'])->name('cursos.store');
    Route::put('/cursos/{curso}', [CursoController::class, 'update'])->name('cursos.update');
    Route::delete('/cursos/{curso}', [CursoController::class, 'destroy'])->name('cursos.destroy');
});

Route::get('/cortes', [CorteController::class, 'index'])->name('cortes');
Route::middleware('catalog.admin')->group(function () {
    Route::post('/cortes', [CorteController::class, 'store'])->name('cortes.store');
    Route::put('/cortes/{corte}', [CorteController::class, 'update'])->name('cortes.update');
    Route::delete('/cortes/{corte}', [CorteController::class, 'destroy'])->name('cortes.destroy');
});

Route::get('/productos', [ProductoController::class, 'index'])->name('productos');
Route::middleware('catalog.admin')->group(function () {
    Route::post('/productos', [ProductoController::class, 'store'])->name('productos.store');
    Route::put('/productos/{producto}', [ProductoController::class, 'update'])->name('productos.update');
    Route::delete('/productos/{producto}', [ProductoController::class, 'destroy'])->name('productos.destroy');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->middleware('throttle:login')->name('login.store');
    Route::post('/register', [RegisterController::class, 'store'])->middleware('throttle:register')->name('register.store');

    Route::get('/recuperar-contrasena', [RecuperarContrasenaController::class, 'mostrarFormularioSolicitud'])->name('contrasena.olvidada');
    Route::post('/recuperar-contrasena', [RecuperarContrasenaController::class, 'enviarCodigo'])
        ->middleware('throttle:password-reset-request')
        ->name('contrasena.olvidada.enviar_codigo');

    Route::get('/recuperar-contrasena/codigo', [RecuperarContrasenaController::class, 'mostrarFormularioCodigo'])
        ->name('contrasena.codigo.formulario');
    Route::post('/recuperar-contrasena/codigo', [RecuperarContrasenaController::class, 'verificarCodigo'])
        ->middleware('throttle:password-reset-verify')
        ->name('contrasena.codigo.verificar');

    Route::get('/recuperar-contrasena/nueva', [RecuperarContrasenaController::class, 'mostrarFormularioNuevaContrasena'])
        ->name('contrasena.nueva.formulario');
    Route::post('/recuperar-contrasena/nueva', [RecuperarContrasenaController::class, 'actualizarContrasena'])
        ->name('contrasena.nueva.guardar');
});

Route::middleware('auth')->group(function () {
    Route::get('/cuenta', AccountController::class)->name('account');
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');
});
