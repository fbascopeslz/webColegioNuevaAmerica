<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    protected $table = 'Alumno';
    protected $primaryKey = 'Id';
    public $timestamps = false;

    protected $fillable = [
        'CI',
        'Nombre',
        'FechaNac',
        'Sexo',
        'Telefono',
        'Email',
        'UsuarioId',
        'Fotografia',
        'Direccion'
    ];
}
