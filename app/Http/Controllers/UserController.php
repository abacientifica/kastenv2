<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;

class UserController extends Controller
{
    public function index(Request $request)
    {
        
        $criterio = $request->criterio;
        $filtro = $request->buscar;
        $usuarios = User::where('Usuario','<>','');
        if($filtro !='' && $filtro =='conf'){
            $Usr = \Auth::user()->Usuario;
            $usuarios = $usuarios->where('Usuario','=',$Usr);
        }
        else if($criterio !='' && $filtro !=''){
            $usuarios = $usuarios->where($criterio,'like','%'.$filtro.'%');
        }
        $usuarios = $usuarios->paginate(20);
        return [
            'pagination' => [
                'total'        => $usuarios->total(),
                'current_page' => $usuarios->currentPage(),
                'per_page'     => $usuarios->perPage(),
                'last_page'    => $usuarios->lastPage(),
                'from'         => $usuarios->firstItem(),
                'to'           => $usuarios->lastItem(),
            ],
            'usuarios'=> $usuarios
        ];
    }

    public function store(Request $request)
    {
        if(!$request->ajax()){
            return  redirect('/');
        }
        $usuarios = new User();
        $usuarios->id = $request->id;
        $usuarios->usuario = $request->usuario;
        $usuarios->password = bcrypt($request->password);
        $usuarios->idrol = $request->idrol;
        $usuarios->save();
    }

    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if(!$request->ajax()){
            return  redirect('/');
        }
        $usuarios = User::findOrFail($request->usuario);
        $usuarios->Tipo = $request->tipo;
        $usuarios->Contrasena= $request->password;
        $usuarios->password = bcrypt($request->password);

        $usuarios->Nombres = $request->nombres;
        $usuarios->Apellidos = $request->apellidos;
        $usuarios->IdTercero = $request->idtercero;
        $usuarios->Cargo = $request->cargo;
        $usuarios->Email = $request->email;

        $usuarios->save();
    } 

    /**
     * 
     */
    public function activar(Request $request)
    {
        if(!$request->ajax()){
            return  redirect('/');
        }
        $usuarios = User::findOrFail($request->id);
        $usuarios->Inactivo = 0;
        $usuarios->save();
    }

    /**
     * 
     */
    public function desactivar(Request $request)
    {
        if(!$request->ajax()){
            return  redirect('/');
        }
        $usuarios = User::findOrFail($request->id);
        $usuarios->Inactivo = 1;
        $usuarios->save();
    }
}
