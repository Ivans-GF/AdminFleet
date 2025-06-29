<?php

namespace App\Models\ControlFlota;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Licencia extends Model
{
    use HasFactory;

    protected $table = 'licencias';

    protected $fillable = [
        'idoperador',
        'archivo',
        'nolicencia',
        'categorias',
        'fechavigencia',
        'estado',
        'created_iduser',
        'updated_iduser',
    ];
}
