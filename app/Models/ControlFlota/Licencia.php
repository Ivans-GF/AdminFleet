<?php

namespace App\Models\ControlFlota;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Licencia extends Model
{
    use HasFactory;

    protected $table = 'licencias';

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
