<?php

namespace App\Http\Controllers;
use App\Mail\EmailBolsa;
use App\Mail\EmailProveedor;
use Illuminate\Http\Request;
use Mail;
use Illuminate\Support\Facades\Config;

class ProveedorController extends Controller
{
    //

    public function __construct(){

    }

    public function nuevo(){
        $data = [];
        return view('content/proveedor/proveedor',$data);
    }



    public function send(Request $request){
        $data = [];

        $data['correo'] = $request->input('correo');
        $data['nombre'] = strtoupper($request->input('nombre'));
        $data['telefono'] = $request->input('telefono');
        $data['ocupacion'] = $request->input('ocupacion');
        $data['servicios'] = $request->input('servicios');
        $data['trabajos'] = $request->input('trabajos');



        $data['email_send'] = false;
        if($request->isMethod('post')){


            if(
            $this->validate($request,[
                "correo" => "required|email",
                "nombre" => "required",
                "telefono" => "required",
                "ocupacion"=>"required",
                "servicios"=>"required",
                "trabajos"=>"required"
            ])
            ){


                $detalle = [
                    'to' => Config::get('constants.EMAIL_PROVEEDORES'),
                    'from' => 'adminweb@eliteexperiencevip.com',
                    'subject' => "mensaje de fromulario de proveedor de ".$data['nombre'],
                    'title' => "Se ha mandado un correo desde el formulario de proveedores",
                    "nombre"  => $data['nombre'],
                    'email' => $data['correo'],
                    'telefono' => $data['telefono'],
                    'ocupacion' => $data['ocupacion'],
                    'trabajos' => $data['trabajos'],
                    'servicios' => $data['servicios']
                ];

                Mail::send(new EmailProveedor($detalle));

                return view('content/proveedor/enviado', $data);


            }else {

                return redirect('proveedores');

            }


        }


    }


}
