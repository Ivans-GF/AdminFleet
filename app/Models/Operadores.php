<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Operadores extends Model
{
    protected $table = 'operadores';
    protected $primaryKey = 'id';


    protected $fillable = [
        'curp',
        'rfc',
        'nombre',
        'apellido',
        'domicilio',
        'fechanacimiento',
        'nota',
        'estado',
        'estatus',
        'updated_iduser',
    ];
}
