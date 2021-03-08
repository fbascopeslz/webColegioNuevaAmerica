<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable
{
    protected $table = 'Usuario';
    protected $primaryKey = 'Id';
    public $timestamps = false;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'Usuario',
        'Contrasenia',
        'GrupoId'        
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
                
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */    
    /*
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];*/

/* 
    //Para hacer referencia a la tabla Rol
    public function rol(){
        return $this->belongsTo('App\Rol');
    }
*/

}
