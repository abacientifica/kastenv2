<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TiposDirecciones extends Model
{
    protected $table ="tipos_direcciones";
    protected $primaryKey ='IdTipoDireccion';
    public $timestamps = false;
}
