<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $anio = '2019';
        $IdTercero =  \Auth::user()->IdTercero;
        $pedidos = DB::select("select MONTH(FechaDet) as mes ,YEAR(FechaDet) as anio ,SUM(movimientos_det.Total) as total  from movimientos_det where IdDocumento = 61 and IdTercero = ".$IdTercero."
        GROUP BY MONTH(FechaDet),YEAR(FechaDet)");
        /* ->select(DB::raw("MONTH(movimientos.Fecha) as mes"),DB::raw("YEAR(movimientos.Fecha) as anio"),DB::raw("SUM(movimientos.Total) as total"))
        ->whereYear("movimientos.Fecha","=",$anio)
        ->where('IdTercero','=',$IdTercero)
        ->where('IdDocumento','61')
        ->groupBy(DB::raw("MONTH(movimientos.Fecha)"),DB::raw("YEAR(movimientos.Fecha)"))
        ->get(); */

        $ventas=DB::table('movimientos')
        ->select(DB::raw('MONTHNAME(movimientos.Fecha) as mes'),
        DB::raw('YEAR(movimientos.Fecha) as anio'),
        DB::raw('SUM(movimientos.Total) as total'))
        ->whereYear('movimientos.Fecha',$anio)
        ->where('IdTercero','=',$IdTercero)
        ->where('IdDocumento','=','3')
        ->groupBy(DB::raw('MONTHNAME(movimientos.Fecha)'),DB::raw('YEAR(movimientos.Fecha)'))
        ->get(); 

        $remisiones = DB::select("select MONTH(FhAutoriza) as mes ,YEAR(FhAutoriza) as anio,sum(Total) as total from movimientos where IdDocumento = 11 and IdTercero =".$IdTercero." and Fecha >='2019-09-01' group by MONTH(FhAutoriza) ,YEAR(FhAutoriza)");
        return [
            "pedidos"=>$pedidos,
            "ventas"=>$ventas,
            'remisiones'=>$remisiones,
            "anio"=>$anio
        ];
    }
}
