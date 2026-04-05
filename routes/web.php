<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

Route::controller(PageController::class)->group(function () {
    Route::get('/', 'home')->name('home');
    Route::get('/cortes', 'cortes')->name('cortes');
    Route::get('/cursos', 'cursos')->name('cursos');
    Route::get('/productos', 'productos')->name('productos');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->middleware('throttle:login')->name('login.store');
    Route::post('/register', [RegisterController::class, 'store'])->middleware('throttle:register')->name('register.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/cuenta', AccountController::class)->name('account');
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');
});
