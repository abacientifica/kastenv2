<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConceptosDocumentos extends Model
{
    protected $table='conceptosdocumentos';
    public $timestamps = false;
    public $primarykey = ['IdConcepto','IdDocumento'];
}
