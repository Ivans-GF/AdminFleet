<?php

namespace App\Http\Controllers\Modulos\ControlFlota;

use App\Http\Controllers\Controller;
use App\Http\Requests\ControlFlota\OperadoresRequest;
use App\Models\ControLFlota\Operador;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Francerz\MX_CURP\CURP;
use Illuminate\Http\RedirectResponse;
class Operadores_ControlFlota extends Controller
{
    public function index(): Response{
         $operadores = Operador::all();
        return Inertia::render('ControlFlota/Operadores/index',[
            'operadores' => $operadores 
        ]);
    }

    public function create(): Response{
        return Inertia::render('ControlFlota/Operadores/create');
    }

    public function store (OperadoresRequest $request) : RedirectResponse {
        $operador = new Operador ($request->validated());
        $operador->curp = $request->input('curp');
        $operador->rfc = $request->input('rfc');
        $operador->nss = $request->input('nss');
        $operador->nombre = $request->input('nombre');
        $operador->apellido = $request->input('apellido');
        $operador->domicilio = $request->input('domicilio');
        $curp = new CURP($request->input('curp'));
        $operador->fechanacimiento = $curp->getFechaNacimiento();
        $operador->nota = $request->input('nota');
        $operador->estado = 1;
        $operador->estatus = 1;
        $operador->created_iduser = auth()->id();
        $operador->updated_iduser = auth()->id(); 
        $operador->save();
        return redirect()->route('operadores.index')->with('success', 'Operador creado correctamente.');
    }

    public function edit(Operador $operador): Response
    {

        if (!$operador) {abort(404, 'Operador no encontrado.');}
        return Inertia::render('ControlFlota/Operadores/edit', [
            'operador' => $operador,
        ]);
    }
}