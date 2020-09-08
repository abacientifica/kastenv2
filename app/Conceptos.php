<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Conceptos extends Model
{
    protected $table='conceptos';
    public $timestamps = false;
    public $primarykey = 'IdConcepto';
}
