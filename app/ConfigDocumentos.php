<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConfigDocumentos extends Model
{
    protected $table="config_documentos";
    public $timestamps = false;
    public $primarykey = 'IdCampo';
}
