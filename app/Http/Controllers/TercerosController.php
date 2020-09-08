<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Terceros;

class TercerosController extends Controller
{
    public function ObtenerClientes(Request $request)
    {
        /* if(!$request->ajax()){
            return  redirect('/');
        } */
        $filtro = $request->filtro;
        $terceros = Terceros::select('IdTercero','NombreCorto','IdTercero')
                                ->where('NombreCorto','like',"%".$filtro."%")
                                ->where('Inactivo',0)
                                ->where('Cliente',1)
                                ->orWhere('IdTercero','like',"%".$filtro."%")
                                ->orderBy('NombreCorto','asc')->take(10)->get();
        return [
            'terceros'=>$terceros
        ];
    }
}
