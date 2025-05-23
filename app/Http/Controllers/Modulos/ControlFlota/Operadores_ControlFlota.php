<?php

namespace App\Http\Controllers\Modulos\ControlFlota;

use App\Http\Controllers\Controller;
use App\Http\Requests\ControlFlota\OperadoresRequest;
use App\ModelsControFlota\Operador;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class Operadores_ControlFlota extends Controller
{
    public function index(): Response
    {
        return Inertia::render('ControlFlota/Operadores/index');
    }

    public function create(): Response
    {
        return Inertia::render('ControlFlota/Operadores/create');
    }

    public function store (OperadoresRequest $request) : RedirectResponse {
        $operador = new Operador ($request->validated());
        $operador->save();
        return redirect()->route('operadores.index')->with('success', 'Tarea creeada correctamente');
    }
}