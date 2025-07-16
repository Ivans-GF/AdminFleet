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
Route::GET('/', function () {
    return Redirect::route('inicio');
});

Route::GET('/inicio', function () {
    return Inertia::render('inicio');
})->middleware(['auth', 'verified'])->name('inicio');

//Control Flotilla
Route::group(['prefix' => 'control-flota', 'middleware' => ['auth', 'verified']], function () {
    //Dasboard Flota
    Route::GET('/index', [Dashboard_ControlFlota::class, 'index'])->name('index.controflota');
    //Operadores
    Route::GET('/operadores/index', [Operadores_ControlFlota::class, 'index'])->name('operadores.index');
    Route::GET('/operadores/create', [Operadores_ControlFlota::class, 'create'])->name('operadores.create');
    Route::POST('/operadores/store', [Operadores_ControlFlota::class, 'store'])->name('operadores.store');
    //Editar Operadores
    Route::GET('/operadores/{operador}/edit', [Operadores_ControlFlota::class, 'edit'])->name('operadores.edit');
    Route::PATCH('/operadores/{operador}', [Operadores_ControlFlota::class, 'update'])->name('operadores.update');
    //Gestion de Licencia
    Route::GET('/operadores/{operador}/gestionlicencia', [Operadores_ControlFlota::class, 'gestionlicencia'])->name('operadores.gestionlicencia');
    Route::POST('/operadores/storelicencia', [Operadores_ControlFlota::class, 'storelicencia'])->name('operadores.storelicencia');

    Route::DELETE('/operadores/{idlicencia}/deletelicencia', [Operadores_ControlFlota::class, 'destroylicencia'])
        ->name('licencia.delete');

    Route::get('/licencias/{idlicencia}/ver-licencia', [Operadores_ControlFlota::class, 'getOperadorLicense'])->name('operadores.ver-licencia');

    //Unidades
    Route::GET('unidades/index', [Unidades_ControlFlota::class, 'index'])->name('unidades.index');



    //Control Operadores
    //Control Unidades

    return Inertia::render('inicio');
});

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
