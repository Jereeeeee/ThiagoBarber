<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/cortes', function () {
    return view('cortes');
})->name('cortes');

Route::get('/cursos', function () {
    return view('cursos');
})->name('cursos');

Route::get('/productos', function () {
    return view('productos');
})->name('productos');
