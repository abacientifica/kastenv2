<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Documentos;
use App\ConfigDocumentosDet;
use App\ConfigDocumentos;

class DocumentosController extends Controller
{
    public function __construct()
    {
        if(!\Auth::check()){
           return  redirect('/login');
        }
    }

    public function GuardarCampoConfiguracion(Request $request){
        if(!$request->ajax()){
            return  redirect('/');
        } 
        $DatoNew = new ConfigDocumentosDet();
        $DatoNew->IdDoc = $request->IdDoc;
        $DatoNew->IdCampo = $request->IdCampo;
        $DatoNew->AliasCampo = $request->AliasCampo;
        $DatoNew->save();
        return[
            true
        ];
    }

    public function ObtenerDocumentosTp(Request $request){
        if(!$request->ajax()){
            return  redirect('/');
        } 
        $Criterio = $request->criterio;
        $Filtro = $request->buscar;
        if($request->Tp > 0){
            $documentos = Documentos::select('IdDocumento','Nombre','Consecutivo')->where("Tp",$request->Tp)->paginate(20);
        }
        else{
            $documentos = Documentos::where('Tp','<>',0);
            if($Criterio !='' && $Filtro !=''){
                $documentos = $documentos->where('Nombre','like','%'.$Filtro.'%');
            }
            $documentos = $documentos->OrderBy('IdDocumento')->paginate(20);
        }
        return [
            'documentos'=> $documentos,
            'Nombre'=>'Facturación',
            'pagination' => [
                'total'        => $documentos->total(),
                'current_page' => $documentos->currentPage(),
                'per_page'     => $documentos->perPage(),
                'last_page'    => $documentos->lastPage(),
                'from'         => $documentos->firstItem(),
                'to'           => $documentos->lastItem(),
            ],
        ];
    }

    public function CargarCamposconfiguracion(Request $request)
    {
        $IdDoc = $request->IdDoc;
        $Sql ='';
        if(isset($request->Exist)){
            $Sql.=" having(Existe is not null)";
        }
        $Campos = DB::select("select config_documentos.*,
                            (select config_documentos_det.AliasCampo from config_documentos_det where config_documentos_det.IdCampo= config_documentos.IdCampo and  config_documentos_det.IdDoc = ".$IdDoc." ) as Existe
                            from config_documentos ".$Sql);
        
        return[
            'campos'=>$Campos
        ];
    }

    public function EliminarCampoconfiguracion(Request $request)
    {
        $IdDoc = $request->IdDoc;
        $IdCampo = $request->IdCampo;
        $Campo = ConfigDocumentosDet::where('IdDoc','=',$IdDoc)->where('IdCampo',$IdCampo)->delete();
        
        return[
            true
        ];
    }
}
