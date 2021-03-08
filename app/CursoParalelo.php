<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CursoParalelo extends Model
{
    protected $table = 'CursoParalelo';
    protected $primaryKey = 'Id';
    public $timestamps = false;

    protected $fillable = [        
        'CursoId',
        'ParaleloId'
    ];

    public function Curso(){
        return $this->belongsTo('App\Curso');
    }

    public function Paralelo(){
        return $this->belongsTo('App\Paralelo');
    }
}
