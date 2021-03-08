<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    protected $table = 'Asistencia';
    protected $primaryKey = 'Id';
    public $timestamps = false;

    protected $fillable = [
        'Fecha',
        'Hora',
        'IdTipoAsistencia',
        'IdOferta',
        'IdAlumno',
        'IdPeriodo'     
    ];
}
