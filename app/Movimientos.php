<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movimientos extends Model
{
    public $timestamps = false;

    protected $primaryKey ='IdMovimiento';
    
    protected $fillable = [
        'IdDocumento',
        'TpDocumento',
        'NroDocumento',
        'Fecha',
        'FhFacProv',
        'Fecha1',
        'Fecha2',
        'IdTercero',
        'IdTercero2',
        'IdFormaPago',
        'IdDireccion',
        'IdAsesor',
        'IdConcepto',
        'IdContrato',
        'Soporte',
        'IdCondEntrega',
        'DocEnlace',
        'Estado',
        'VrIva',
        'VrDcto',
        'VrOtros',
        'VrFletes',
        'VrRetencion',
        'VrRteFuente',
        'VrRteIva',
        'VrRteCree',
        'SubTotal',
        'Total',
        'Costo',
        'IdUsuario',
        'IdAutoriza',
        'FhAutoriza',
        'Prioridad',
        'Comentarios',
        'ComentariosInternos',
        'Abono',
        'Saldo',
        'EnNovedad',
        'Importado',
        'Anulado',
        'Confirmado',
        'Autorizado',
        'Autorizado2',
        'Impresion',
        'Revisado',
        'Entregado',
        'Ventanilla',
        'Digitalizado',
        'Alistado',
        'IdUsuarioAlista',
        'CierreContable',
        'Contabilizado',
        'IdTpOc',
        'Alistando',
        'Despachado',
        'TotalUnidades',
        'TotalPeso',
        'NoAplicaContrato',
        'IdPromocion',
        'VrFletePagado',
        'SolicitadoLogistica',
        'RecibidoLogistica',
        'Interno',
        'PrioridadAct',
    ];
    
    public function documento(){
        return $this->hasOne('App\Documentos','IdDocumento','IdDocumento');
    }

    public function asesor(){
        return $this->hasOne('App\Asesores','IdAsesor','IdAsesor');
    }

    //Relacion de uno a muchos
    public function detalles(){
        return $this->hasMany('App\MovimientosDet','IdMovimiento','IdMovimiento');
    }

    public function tercero(){
        return $this->hasMany('App\Terceros','IdTercero','IdTercero');
    }


}

