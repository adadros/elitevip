<?php

namespace App\Http\Controllers;
use App\Mail\EmailBolsa;
use Illuminate\Http\Request;
use Mail;
use Illuminate\Support\Facades\Config;

class BolsaController extends Controller
{
    //

    public function __construct(){

    }

    public function nuevo(){
        $data = [];
        return view('content/bolsatrabajo/bolsatrabajo',$data);
    }



    public function send(Request $request){
        $data = [];

        $data['correo'] = $request->input('correo');
        $data['nombre'] = strtoupper($request->input('nombre'));
        $data['telefono'] = $request->input('telefono');
        $data['ocupacion'] = $request->input('ocupacion');
        $data['trabajos'] = $request->input('trabajos');



        $data['email_send'] = false;
        if($request->isMethod('post')){


            if(
            $this->validate($request,[
                "correo" => "required|email",
                "nombre" => "required",
                "telefono" => "required",
                "ocupacion"=>"required",
                "trabajos"=>"required"
            ])
            ){


                $detalle = [
                    'to' => Config::get('constants.EMAIL_BOLSATRABAJO'),
                    'from' => 'adminweb@eliteexperiencevip.com',
                    'subject' => "Mensaje de bolsa de trabajo de ".$data['nombre'],
                    'title' => "Se ha mandado un correo desde el formulario de bolsa de trabajo",
                    "nombre"  => $data['nombre'],
                    'email' => $data['correo'],
                    'telefono' => $data['telefono'],
                    'ocupacion' => $data['ocupacion'],
                    'trabajos' => $data['trabajos']
                ];

                Mail::send(new EmailBolsa($detalle));

                return view('content/bolsatrabajo/enviado', $data);


            }else {

                return redirect('bolsatrabajo');

            }


        }


    }


}
