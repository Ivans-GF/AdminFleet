<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;

use Inertia\Inertia;

//Validar direccion raiz //
Route::get('/', function () {
    return Redirect::route('inicio');
});

Route::get('/inicio', function () {
    return Inertia::render('inicio');
})->middleware(['auth', 'verified'])->name('inicio');
//Control Flotilla

Route::group(['prefix' => 'control-flota', 'middleware' => ['auth', 'verified']], function () {

    return Inertia::render('inicio');
});
require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
