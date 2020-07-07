<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Direcciones;
class DireccionesController extends Controller
{
    public function __construct()
    {
        if(!\Auth::check()){
           return  redirect('/login');
        }
    }
    public function ObtenerDireccionesTercero(Request $request)
    {
        $IdTercero = \Auth::user()->IdTercero;
        $direcciones = Direcciones::select('IdDireccion','NmDireccion')->where('IdTercero','=',$IdTercero)->get();
        return[
            'direcciones'=>$direcciones
        ];
    }
}
