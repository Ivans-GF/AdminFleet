<?php

namespace App\Models\ControlFlota;

use Illuminate\Database\Eloquent\Model;

class Operador extends Model
{
    protected $table = 'operadores';
    protected $primaryKey = 'id';


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
