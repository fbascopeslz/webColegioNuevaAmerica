<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inscripcion extends Model
{
    protected $table = 'Inscripcion';
    protected $primaryKey = 'Id';
    public $timestamps = false;

    protected $fillable = [        
        'Fecha',
        'CursoParaleloId',
        'AlumnoId',
        'Gestion'
    ];

    public function CursoParalelo(){
        return $this->belongsTo('App\CursoParalelo');
    }

    public function Alumno(){
        return $this->belongsTo('App\Alumno');
    }
}
