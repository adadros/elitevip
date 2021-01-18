<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\User as User;
use App\Perfil as Perfil;
use App\Djs as Djs;
use App\Paises as Paises;
use App\UserRole as UserRole;

class RegisterController extends Controller
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
        return view('register/form',$data);
    }


    public function create_new(Request $request, User $usuario, Perfil $perfil, UserRole $user_role){
        $data = [];

        $data['correo'] = $request->input('correo');
        $data['nombre'] = strtoupper($request->input('nombre'));
        $data['apellido'] = strtoupper($request->input('apellido'));
        $data['telefono'] = $request->input('telefono');
        $data['ocupacion'] = $request->input('ocupacion');
        $data['paises'] = is_null($request->input('paises')) ? $request->input('paises') : implode(",",$request->input('paises'));
        $data['hoteles'] = $request->input('hoteles');
        $data['djs'] = is_null($request->input('djs')) ? $request->input('djs') : implode(',',$request->input('djs'));
        $data['tipomusica'] = $request->input('tipomusica');
        $data['hobbie'] = $request->input('hobbie');
        $data['redes'] = $request->input('redes');


        $data['existemail'] = false;

        $data['mod'] = 1;
        if($request->isMethod('post')){


            if(
                $this->validate($request,[
                    "correo" => "required|email|unique:users,email",
                    "nombre" => "required",
                    "apellido" => "required",
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

                $existe_correo = $this->checkEmailExist($data['correo']);
                if(count($existe_correo)>0){
                    $data['existemail'] = true;
                }else {
                    $usuario->email = $request->input('correo');
                    $usuario->password = Hash::make('12345');
                    $usuario->save();
                    $perfil->uid = $usuario->id;
                    $perfil->nombre = $data['nombre'];
                    $perfil->apellido = $data['apellido'];
                    $perfil->email = $data['correo'];
                    $perfil->telefono = $data['telefono'];
                    $perfil->ocupacion = $data['ocupacion'];
                    $perfil->paises_favoritos = $data['paises'];
                    $perfil->hoteles_favoritos = $data['hoteles'];
                    $perfil->dj_favorito = $data['djs'];
                    $perfil->tipo_musica = $data['tipomusica'];
                    $perfil->hobbies = $data['hobbie'];
                    $perfil->redes_sociales = $data['redes'];

                    $perfil->save();

                    $user_role->uid = $usuario->id;
                    $user_role->rid = 2;
                    $user_role->save();

                    $data['uid'] = $usuario->id;
                }

                return view('register/nuevo', $data);


            }else {

                return redirect('registro');

            }


        }


    }

    public function checkEmailExist($email){
        $correo_encontrado = DB::table('users as u')
                        ->select('u.id')
                        ->whereRaw('u.email = ?',[$email])
                        ->get();

        return $correo_encontrado;

    }

}
