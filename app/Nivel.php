<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nivel extends Model
{
    protected $table = 'Nivel';
    protected $primaryKey = 'Id';
    public $timestamps = false;

    protected $fillable = [        
        'Nombre'        
    ];
}
