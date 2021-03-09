<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Periodo extends Model
{
    protected $table = 'Periodo';
    protected $primaryKey = 'Id';
    public $timestamps = false;

    protected $fillable = [                
        'Numero',
        'FechaInicio',
        'FechaFin',
        'Anio',
        'Descripcion'
    ];
}
