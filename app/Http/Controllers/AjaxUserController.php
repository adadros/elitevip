<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Mail;
use App\Mail\EmailAprobado;
use App\User as User;
use App\Perfil as Perfil;
use App\UserRole as UserRole;


class AjaxUserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','auth.admin']);
    }

    public function aprobar(Request $request){
        if($request->ajax()){

            $validacion = Validator::make(
                $request->all(),[
                    'id' => 'required',
                    'nombre' => 'required',
                    'email' => 'required|email'
                ]
            );
            if($validacion->passes()){

                $pass = $this->rand_string(13);
                $id = $request->input('id');

                $detalle = [
                    'to' => $request->input('email'),
                    'from' => 'adminweb@eliteexperiencevip.com',
                    'subject' => "Mensaje de aprobación",
                    'title' => "Bienvenido a Elite Experience Vip",
                    "nombre"  => $request->input('nombre'),
                    'email' => $request->input('email'),
                    "password" => $pass
                ];

                User::whereId($id)->update([
                    'password' => Hash::make($pass),
                    'activo' => 1,
                ]);

                Mail::send(new EmailAprobado($detalle));

                return response()->json([
                    'message'=>'El usuario se ha aprobado con éxito, se le ha enviado un correo electrónico con su contraseña',
                    'activated'=>true

                ]);
            }else{
                return response()->json([
                    'message' => $validacion->errors()->all(),
                    'activated' => false
                ]);
            }

        }
    }



    public function guardar(Request $request, User $user, UserRole $user_role, Perfil $perfil){

        if($request->ajax()){

            $validacion = Validator::make(
                $request->all(),[
                    'nombre' => 'required',
                    'apellido' => 'required',
                    'correo' => 'required|email|unique:users,email',
                    'role' => 'required',

                ]
            );
            if($validacion->passes()){
                $aprobar = $request->input('aprobar');

                $pass = $this->rand_string(13);
                $user->nombre = $request->input('nombre');
                $user->apellido = $request->input('apellido');
                $user->correo = $request->input('correo');
                $user->password = Hash::make($pass);
                $user->save();

                $perfil->uid = $user->id;
                $perfil->nombre = $request->input('nombre');
                $perfil->apellido = $request->input('apellido');
                $perfil->email = $request->input('correo');
                $perfil->save();

                $user_role->uid = $user->id;
                $user_role->rid = $request->input('role');
                $user_role->save();

                if(isset($aprobar)){
                    
                }


                return response()->json([
                    'message'=>'El usuario con nombre '.$user->nombre.' '.$user->apellido.' se ha guardado con éxito',
                    'saved'=>true

                ]);
            }else{

                return response()->json([
                    'message' => $validacion->errors()->all(),
                    'saved' => false
                ]);
            }



        }

    }

    public function actualizar(Request $request){
        /*if($request->ajax()){

            $validacion = Validator::make(
                $request->all(),[
                    'nombre' => 'required',
                    'precio' => 'required',
                    'personas' => 'required',
                ]
            );
            if($validacion->passes()){

                $id= $request->input('id');
                Paquete::whereId($id)->update([
                    'nombre' => $request->input('nombre'),
                    'precio' => $request->input('precio'),
                    'personas' => $request->input('personas'),
                ]);

                return response()->json([
                    'message'=>'El paquete se ha actualizado con éxito',
                    'updated'=>true,
                ]);
            }else{
                return response()->json([
                    'message' => $validacion->errors()->all(),
                    'updated' => false
                ]);
            }
        }*/
    }

    public function eliminar(Request $request){
       /* if($request->ajax()){

            $validacion = Validator::make(
                $request->all(),[
                    'id' => 'required',
                ]
            );
            if($validacion->passes()){

                $id= $request->input('id');
                Paquete::whereId($id)->delete();


                return response()->json([
                    'message'=>'El paquete se ha eliminado',
                    'deleted'=>true,
                ]);
            }else{
                return response()->json([
                    'message' => $validacion->errors()->all(),
                    'deleted' => false
                ]);
            }
        }*/
    }


    public function rand_string( $length ) {

        $chars = "abcdefghijklmnopqrstuv#wxyzABCDEFG_HIJKLMNOPQRSTUVWXYZ0123456789";
        return substr(str_shuffle($chars),0,$length);

    }


}
