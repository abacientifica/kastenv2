<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ListaPrecios extends Model
{
    protected $fillable = [
        'IdListaPrecios',
        'NmListaPrecios',
        'Fecha',
        'FhVenceLista',
        'IdUsuario',
        'Comentarios',
        'Inactiva',
        'IdDocumento',
        'Anyo',
    ];
}
