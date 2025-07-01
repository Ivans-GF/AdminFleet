<?php

namespace App\Http\Controllers\Modulos\ControlFlota;

use App\Http\Controllers\Controller;
use App\Http\Requests\ControlFlota\OperadoresRequest;
use App\Http\Requests\ControlFlota\UpdateOperadoresRequest;
use App\Http\Requests\ControlFlota\LicenciaRequest;

use App\Models\ControLFlota\Operador;
use App\Models\ControLFlota\Licencia;
use Inertia\Inertia;
use Inertia\Response;
use Francerz\MX_CURP\CURP;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class Operadores_ControlFlota extends Controller
{
    public function index(): Response
    {
        $operadores = Operador::where('estado', 1)->get();
        return Inertia::render('ControlFlota/Operadores/index', [
            'operadores' => $operadores
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('ControlFlota/Operadores/create');
    }

    public function store(OperadoresRequest $request): RedirectResponse
    {
        $operador = new Operador($request->validated());
        $operador->curp = strtoupper($request->input('curp'));
        $operador->rfc = strtoupper($request->input('rfc'));
        $operador->nss = $request->input('nss');
        $operador->rfc = strtoupper($request->input('rfc'));
        $operador->telefono = strtoupper($request->input('telefono'));
        $operador->nombre = mb_convert_case($request->input('nombre'), MB_CASE_TITLE, "UTF-8");
        $operador->apellido = mb_convert_case($request->input('apellido'), MB_CASE_TITLE, "UTF-8");
        $operador->domicilio = $request->input('domicilio');
        $curp = new CURP($request->input('curp'));
        $operador->fechanacimiento = $curp->getFechaNacimiento();
        $operador->nota = $request->input('nota');
        $operador->estado = 1;
        $operador->created_iduser = auth()->id();
        $operador->updated_iduser = auth()->id();
        $operador->documentos = 0; // No  tiene ningun documento - Falta validacion
        $operador->save();
        return redirect()->route('operadores.index')->with('success', 'Operador creado correctamente.');
    }

    public function edit($idoperador)
    {
        $operador = Operador::find($idoperador);
        if (!$operador) {
            return redirect()->route('operadores.index')->with('error', 'Operador no encontrado.');
        }
        return Inertia::render('ControlFlota/Operadores/edit', [
            'operador' => $operador,
        ]);
    }

    public function update(UpdateOperadoresRequest $request, Operador $operador): RedirectResponse
    {
        $validatedData = $request->validated();
        $validatedData['updated_iduser'] = auth()->id();
        $validatedData['curp'] = strtoupper($validatedData['curp']);
        $validatedData['rfc'] = strtoupper($validatedData['rfc']);

        $validatedData['nombre'] = mb_convert_case($validatedData['nombre'], MB_CASE_TITLE, "UTF-8");
        $validatedData['apellido'] = mb_convert_case($validatedData['apellido'], MB_CASE_TITLE, "UTF-8");

        $operador->update($validatedData);
        return redirect()->route('operadores.index')->with('success', 'Información de operador modificada correctamente.');
    }

    public function gestionlicencia($idoperador)
    {

        $operador = Operador::find($idoperador);
        if (!$operador) {
            return redirect()->route('operadores.index')->with('error', 'Operador no encontrado.');
        }
        $licencias = Licencia::WHERE('idoperador', $idoperador)->get();
        return Inertia::render('ControlFlota/Operadores/GestionLicencia', [
            'operador' => $operador,
            'licencias' => $licencias
        ]);
    }

      public function storelicencia(LicenciaRequest $request): RedirectResponse
    {

        return redirect()->route('operadores.index')->with('success', 'Operador creado correctamente.');
    }
}
