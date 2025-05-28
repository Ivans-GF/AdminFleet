<?php
//Modulos
//Control Flota
use App\Http\Controllers\Modulos\ControlFlota\Dashboard_ControlFlota;
use App\Http\Controllers\Modulos\ControlFlota\Operadores_ControlFlota;
use App\Http\Controllers\Modulos\ControlFlota\Unidades_ControlFlota;
//Modulos
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
    //Dasboard Flota
    Route::get('/index', [Dashboard_ControlFlota::class, 'index'])->name('index.controflota');
    //Operadores
    Route::get('/operadores/index', [Operadores_ControlFlota::class, 'index'])->name('operadores.index');
    Route::get('/operadores/create', [Operadores_ControlFlota::class, 'create'])->name('operadores.create');
    Route::post('/operadores/store', [Operadores_ControlFlota::class, 'store'])->name('operadores.store');
    Route::get('/operadores/edit/{id}', [Operadores_ControlFlota::class, 'edit'])->name('operadores.edit');








    //Unidades
    Route::get('unidades/index', [Unidades_ControlFlota::class, 'index'])->name('unidades.index');



    //Control Operadores
    //Control Unidades

    return Inertia::render('inicio');
});

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
