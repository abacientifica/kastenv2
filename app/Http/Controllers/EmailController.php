<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function EnviarEmail(Request $request){ 
        $subject = "Prueba Correo"; 
        $for = "auxsistemas@aba.com.co";

        Mail::send('mail.mail',$request->all(), function($msj) use($subject,$for){ 
            $msj->from("kasten@aba.com.co","Kasten V2"); 
            $msj->subject($subject); 
            $msj->to($for); 
        }); 

        return [
            'MensajeEnviado'=>true
        ];
    }
}
