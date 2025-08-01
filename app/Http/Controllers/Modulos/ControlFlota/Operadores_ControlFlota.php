<?php

namespace App\Http\Controllers\Modulos\ControlFlota;

use App\Http\Controllers\Controller;
use App\Http\Requests\ControlFlota\OperadoresRequest;
use App\Http\Requests\ControlFlota\UpdateOperadoresRequest;
use App\Http\Requests\ControlFlota\LicenciaRequest;
use Illuminate\Support\Str;
use App\Models\ControLFlota\Operador;
use App\Models\ControLFlota\Licencia;
use Inertia\Inertia;
use Inertia\Response;
use Francerz\MX_CURP\CURP;
use Illuminate\Http\RedirectResponse;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log; // Import the Log facade

class Operadores_ControlFlota extends Controller
{
    public function index(): Response
    {
        $operadores = Operador::where('operadores.estado', 1)
        ->leftjoin('licencias', 'operadores.id', '=', 'licencias.operador_id')
        ->select('operadores.*', 'licencias.fechavigencia', 'licencias.categoria', 'licencias.archivo')
        ->get();
        // Iterate through the results to calculate days remaining
        $operadores->each(function ($operador) {
            if ($operador->fechavigencia) {
                $fechaVigencia = Carbon::parse($operador->fechavigencia);
                $diasRestantes = now()->diffInDays($fechaVigencia, false); // 'false' to get signed difference (negative for past dates)
                $operador->dias_restanteslicencia = $diasRestantes;
            } else {
                $operador->dias_restanteslicencia = null; // Or some other default value if no validity date
            }

               // --- Implementación para MinIO público ---
            $operador->archivo_licencia_url = null;
            if ($operador->archivo) {
                try {
                    $operador->archivo_licencia_url = Storage::disk('minio')->url($operador->archivo);
                } catch (\Exception $e) {
                    $operador->archivo_licencia_url = null; // En caso de error, no enviar URL inválida
                }
            }
        });

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
        $operador->nolicencia = strtoupper($request->input('nolicencia'));
        $operador->noexpediente = strtoupper($request->input('noexpediente'));
        $operador->estado = 1;
        $operador->created_iduser = auth()->id();
        $operador->updated_iduser = auth()->id();
        $operador->documentosestatus = 0; // No  tiene ningun documento - Falta validacion
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

    public function gestionlicencia($operador_id)
    {
        $operador = Operador::find($operador_id);
        if (!$operador) {
            return redirect()->route('operadores.index')->with('error', 'Operador no encontrado.');
        }
        $licencias = Licencia::WHERE('operador_id', $operador_id)->get();
        return Inertia::render('ControlFlota/Operadores/GestionLicencia', [
            'operador' => $operador,
            'licencias' => $licencias
        ]);
    }

    public function storelicencia(LicenciaRequest $request): RedirectResponse
    {
        $filePath = null;
        if ($request->hasFile('archivo')) {
           $file = $request->file('archivo');
            $fileName = Str::random(40) . '.' . $file->getClientOriginalExtension();
            $folderPath = 'operadores/licencias'; // Define a folder within your disk for licenses
        try {
            $filePath = Storage::disk('minio')->putFileAs($folderPath, $file, $fileName);
            } catch (\Exception $e) {
                return redirect()->back()->withInput($request->except('archivo'))
                    ->with('error', 'Error al subir el archivo de la licencia: ' . $e->getMessage());
            }
        }

        $licencia = new Licencia($request->validated());
        $licencia->operador_id = $request->input('operador_id');
        $licencia->archivo = $filePath;
        $licencia->fechavigencia = Carbon::parse($request->input('fechavigencia'))->format('Y-m-d');
        $licencia->categoria = strtoupper($request->input('categoria'));
        $licencia->comentario = $request->input('comentario');
        $licencia->estado = 1;
        $licencia->created_iduser = auth()->id();
        $licencia->updated_iduser = auth()->id();
        $licencia->save();
        // Update the operator's license information using the new function
        $result = $this->updateOperatorLicense($licencia->operador_id);
        if (!$result) {
            return redirect()->back()->with('error', 'Error al ingresar la licencia o actualizar el operador.');
        }
        return redirect()->back()->with('success', 'Licencia almacenada correctamentes.');
    }

    protected function updateOperatorLicense(int $operador_id): bool
    {
        $operador = Operador::find($operador_id);

        if ($operador) {
            $mostRecentActiveLicense = Licencia::where('operador_id', $operador->id)
                ->where('estado', 1)->orderByDesc('fechavigencia')->first();

            $operador->licencia_id = $mostRecentActiveLicense ? $mostRecentActiveLicense->id : null;
            $operador->save();
            return true;
        }

        return false; // Operator not found
    }

    public function destroylicencia($idlicencia): RedirectResponse
    {
        $licencia = Licencia::find($idlicencia);
        if (!$licencia) {
            return redirect()->back()->with('error', 'Licencia no encontrada.');
        }
        // Delete the file from MinIO
        if ($licencia->archivo && Storage::disk('minio')->exists($licencia->archivo)) {
            Storage::disk('minio')->delete($licencia->archivo);
        }
        // Delete the license record
        $licencia->delete();
        // Update the operator's license information
        $this->updateOperatorLicense($licencia->operador_id);
        return redirect()->back()->with('success', 'Licencia eliminada correctamente.');
    }


    public function getOperadorLicense($idlicencia)
    {
        $licencia = Licencia::findOrFail($idlicencia);
        $filePath = $licencia->archivo;
        if ($filePath && Storage::disk('minio')->exists($filePath)) {
            $displayFilename = 'Licencia.pdf';
            return Storage::disk('minio')->response($filePath, $displayFilename, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . $displayFilename . '"'
            ]);
        } else {
            abort(404, 'Archivo de licencia no encontrado.');
        }
    }
}
