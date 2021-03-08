<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Oferta extends Model
{
    protected $table = 'Oferta';
    protected $primaryKey = 'Id';
    public $timestamps = false;
    public $incrementing = true;

    protected $fillable = [        
        'MateriaId',
        'ProfesorId',
        'CursoParaleloId',
        'Gestion'
    ];

    public function Materia(){
        return $this->belongsTo('App\Materia');
    }

    public function Profesor(){
        return $this->belongsTo('App\Profesor');
    }

    public function CursoParalelo(){
        return $this->belongsTo('App\CursoParalelo');
    }
}
