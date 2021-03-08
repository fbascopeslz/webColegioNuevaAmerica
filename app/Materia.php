<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Materia extends Model
{
    protected $table = 'Materia';
    protected $primaryKey = 'Id';
    public $timestamps = false;

    protected $fillable = [        
        'Nombre'        
    ];
}
