<?php

namespace App\Listeners;

use App\Events\update;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\DB;
class Log
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  update  $event
     * @return void
     */
    public function handle(update $event)
    {
        $Log = DB::table('log')->insert(['IdAccion'=>'2','Id_Item'=>'56566','Comentarios'=>'prueba diego', 'Fecha'=>date("Y-m-d H:i:s"),'Usuario'=>'diegoa']);
    }
}
