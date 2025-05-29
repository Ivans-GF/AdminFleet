<?php

namespace App\Models\ControlFlota;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Operador extends Model
{
    use HasFactory;

    protected $table = 'operadores';

    protected $fillable = [
        'curp',
        'rfc',
        'nss',
        'nombre',
        'apellido',
        'telefono',
        'domicilio',
        'fechanacimiento',
        'nota',
        'estado',
        'estatus',
        'updated_iduser',
    ];
}