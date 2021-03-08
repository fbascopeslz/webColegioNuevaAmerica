<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    protected $table = 'Curso';
    protected $primaryKey = 'Id';
    public $timestamps = false;

    protected $fillable = [        
        'Nombre',
        'NivelId'      
    ];

    public function Nivel(){
        return $this->belongsTo('App\Nivel');
    }
}
