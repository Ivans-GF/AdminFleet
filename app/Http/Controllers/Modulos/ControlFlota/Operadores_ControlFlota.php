<?php

namespace App\Http\Controllers\Modulos\ControlFlota;

use App\Http\Controllers\Controller;
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
}
