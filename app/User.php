<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    // La declaramos para decirle el nombre de la tabla 
    protected $table='usuarios';
    
    //La declaramos para decirle que la llave primaria es la que le indiquemos
    protected $primaryKey ='Usuario';

    //La declaramos para decirle que la primary key no es incremental por ejempli Id
    public $incrementing = false;

    //La declaramos para no guardar los datos de fechas automaticamente
    public $timestamps = false;

    protected $fillable = [
        'Usuario',
        'Contrasena',
        'Tipo',
        'Nombres',
        'Apellidos',
        'FacProVenc',
        'Notificaciones',
        'Correos',
        'IdTercero',
        'IdDireccion',
        'Inactivo',
        'Email',
        'InfoNovedadItem',
        'TipoExterno',
        'ExtensionTel',
        'Cargo',
        'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
