<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profesor extends Model
{
    protected $table = 'Profesor';
    protected $primaryKey = 'Id';
    public $timestamps = false;

    protected $fillable = [
        'CI', 
        'Nombre',     
        'FechaNac', 
        'Sexo', 
        'Direccion', 
        'Telefono', 
        'Email',
        'UsuarioId'
    ];
}
