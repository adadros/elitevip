<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Mail;
use App\Mail\EmailContacto;
use App\Djs as Djs;
use App\Paises as Paises;
use Illuminate\Support\Facades\Config;

class ContactoController extends Controller
{
    //

    public function __construct(Djs $djs, Paises $pais){
        $this->djs = $djs->all();
        $this->paises = $pais->all();
    }

    public function nuevo(){
        $data = [];
        $data['djs'] = $this->djs;
        $data['paises'] = $this->paises;
        return view('content/contacto/contacto',$data);
    }



    public function send(Request $request){
        $data = [];

        $data['correo'] = $request->input('correo');
        $data['nombre'] = strtoupper($request->input('nombre'));
        $data['telefono'] = $request->input('telefono');
        $data['ocupacion'] = $request->input('ocupacion');
        $data['paises'] = $request->input('paises');
        $data['hoteles'] = $request->input('hoteles');
        $data['djs'] = $request->input('djs');
        $data['tipomusica'] = $request->input('tipomusica');
        $data['hobbie'] = $request->input('hobbie');
        $data['redes'] = $request->input('redes');


        $data['email_send'] = false;
        if($request->isMethod('post')){


            if(
            $this->validate($request,[
                "correo" => "required|email",
                "nombre" => "required",
                "telefono" => "required",
                "ocupacion"=>"required",
                "paises"=>"required",
                "hoteles"=>"required",
                "djs"=>"required",
                "tipomusica"=>"required",
                "hobbie"=>"required",
                "redes"=>"required"
            ])
            ){

                $paises = Paises::whereIn('id', $data['paises'])->get();
                $paises_selected = [];
                if(isset($paises)){
                    foreach ($paises as $pais){
                        $paises_selected[] = $pais->nombre;
                    }
                }
                $djs = Djs::whereIn('id', $data['djs'])->get();
                $djs_selected = [];
                if(isset($djs)){
                    foreach ($djs as $dj){
                        $djs_selected[] = $dj->nombre;
                    }
                }
                $data['info_paises'] = implode(', ',$paises_selected);
                $data['info_djs'] = implode(', ',$djs_selected);

                $detalle = [
                    'to' => Config::get('constants.EMAIL_CONTACTO'),
                    'from' => 'contacto@eliteexperience.vip',
                    'subject' => "Contacto de ".$data['nombre'],
                    'title' => "Se ha mandado un correo desde el formulario de contacto",
                    "nombre"  => $data['nombre'],
                    'email' => $data['correo'],
                    'telefono' => $data['telefono'],
                    'ocupacion' => $data['ocupacion'],
                    'paises' => $data['info_paises'],
                    'hoteles' => $data['hoteles'],
                    'djs' => $data['info_djs'],
                    'tipomusica' => $data['tipomusica'],
                    'hobbie' => $data['hobbie'],
                    'redes' => $data['redes']
                ];

                Mail::send(new EmailContacto($detalle));

                return view('content/contacto/enviado', $data);


            }else {

                return redirect('contacto');

            }


        }


    }


}
