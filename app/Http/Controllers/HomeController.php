<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Item;
use App\ListaPrecios;
use App\ListaPreciosDet;
use App\Direcciones;
use App\MovimientosDet;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        if(!\Auth::check()){
           return  redirect('/');
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(\Auth::check()){
            return view('contenido/contenido');
        }
        else{
            return  redirect('/');
        }
    }

    public function UpdatePass(Request $request)
    {
        $Usuarios = User::select('Usuario','Contrasena')->OrderBy('Usuario','asc')->get();
        $cont =1;
        foreach($Usuarios as $User){
            //$User->password = bcrypt($User->Contrasena);
            $User->id = $cont;
            $User->save();
            $cont++;
        }
    }

    public function ObtenerDetallesListaPrecios(Request $request){
        $filtro = $request->filtro;
        $criterio = $request->criterio;
        $Id = $request->Id; 
        $Direccion = Direcciones::findOrFail($Id);
        
        $Lista = ListaPreciosDet::select('lista_precios_det.Id_Item','item.Descripcion','item.Disponible','item.Inactivo','Precio','item.Por_Iva')
                ->leftjoin('item','item.Id_Item','=','lista_precios_det.Id_Item')
                ->Where('IdListaPrecios','=',$Direccion->IdListaPreciosDireccion)
                ->where('item.Inactivo','=','0')
                ->where('lista_precios_det.Inactivo','=','0');
        if($criterio !='' && $filtro !=''){
            $Lista = $Lista->Where('item.'.$criterio,'like','%'.$filtro.'%');
        }
        $Lista = $Lista->orderBy('item.Descripcion','asc')->paginate(10);
        
        return[
            'pagination' => [
                'total'        => $Lista->total(),
                'current_page' => $Lista->currentPage(),
                'per_page'     => $Lista->perPage(),
                'last_page'    => $Lista->lastPage(),
                'from'         => $Lista->firstItem(),
                'to'           => $Lista->lastItem(),
            ],
            'productos'=>$Lista
        ];
    }

    public function ObtenerDetallesListaPreciosprueba(Request $request){
        $filtro = $request->filtro;
        $criterio = $request->criterio;
        $Id = 8414; 
        $Direccion = Direcciones::findOrFail($Id);
        
        $Lista2 = ListaPreciosDet::select('lista_precios_det.Id_Item as Item','item.Descripcion as Descripcion','item.Disponible as Disponible','item.Inactivo as Inactivo','Precio','item.Por_Iva as Por_Iva')
                ->leftjoin('item','item.Id_Item','=','lista_precios_det.Id_Item')
                ->Where('IdListaPrecios','=',$Direccion->IdListaPreciosDireccion)
                ->where('item.Inactivo','=','0')
                ->where('lista_precios_det.Inactivo','=','0');

        $Lista = MovimientosDet::select('movimientos_det.Id_Item as Item','item.Descripcion as Descripcion','item.Disponible as Disponible','item.Inactivo as Inactivo','Precio','item.Por_Iva as Por_Iva')
                                ->leftjoin('movimientos','movimientos.IdMovimiento','=','movimientos_det.IdMovimiento')
                                ->leftjoin('item','item.Id_Item','=','movimientos_det.Id_Item')
                                ->where('movimientos.IdTercero','=',$Direccion->IdTercero)
                                ->where('movimientos.IdDocumento','=',3)
                                ->union($Lista2)->get();

        
        /* if($criterio !='' && $filtro !=''){
            $Lista2 = $Lista->Where('item.'.$criterio,'like','%'.$filtro.'%');
        } */
        
        return[
            'productos'=>$Lista
        ];
    }
}
