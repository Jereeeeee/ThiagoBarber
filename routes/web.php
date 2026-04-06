<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\CorteController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductoController;
use Illuminate\Support\Facades\Route;

Route::controller(PageController::class)->group(function () {
    Route::get('/', 'home')->name('home');
    Route::get('/cursos', 'cursos')->name('cursos');
});

Route::get('/cortes', [CorteController::class, 'index'])->name('cortes');
Route::post('/cortes', [CorteController::class, 'store'])->name('cortes.store');
Route::put('/cortes/{corte}', [CorteController::class, 'update'])->name('cortes.update');
Route::delete('/cortes/{corte}', [CorteController::class, 'destroy'])->name('cortes.destroy');

Route::get('/productos', [ProductoController::class, 'index'])->name('productos');
Route::post('/productos', [ProductoController::class, 'store'])->name('productos.store');
Route::put('/productos/{producto}', [ProductoController::class, 'update'])->name('productos.update');
Route::delete('/productos/{producto}', [ProductoController::class, 'destroy'])->name('productos.destroy');

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->middleware('throttle:login')->name('login.store');
    Route::post('/register', [RegisterController::class, 'store'])->middleware('throttle:register')->name('register.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/cuenta', AccountController::class)->name('account');
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');
});
