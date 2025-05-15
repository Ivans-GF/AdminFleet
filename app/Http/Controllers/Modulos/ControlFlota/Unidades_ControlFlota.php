<?php

namespace App\Http\Controllers\Modulos\ControlFlota;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class Unidades_ControlFlota extends Controller
{
    public function index(): Response
    {
        return Inertia::render('ControlFlota/Unidades/index');
    }
}
