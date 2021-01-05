<?php
/**
 * Created by PhpStorm.
 * User: Adad
 * Date: 24/12/2020
 * Time: 08:24 AM
 */
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Evento as Evento;
use App\EventoFecha as Eventofecha;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getProfile(){

        $profile = DB::table('users as u')
            ->select(['u.id','u.email','perfil.nombre','perfil.apellido'])
            ->join('perfil', 'perfil.uid', '=', 'u.id')
            ->whereRaw('u.id = ?',[Auth::id()])
            ->get()->first();


        $arr['nombre'] = $profile->nombre;
        $arr['apellido'] = $profile->apellido;

        return $arr;
    }


    public function view(Evento $evento){
        if(Auth::user()->isActivo(Auth::id())) {
            if (Auth::user()->hasAnyRole(Auth::id(), 'Admin')) {
                return redirect('/admin');
            } else {

                $data['profile'] = $this->getProfile();
                $eventos = $evento->all();

                if(isset($eventos)){
                    foreach ($eventos as $ev){
                        $fecha_arr = [];
                        $fechas = Eventofecha::where(['idevento'=>$ev->id])->get();
                        if(isset($fechas)){
                            foreach ($fechas as $fecha){
                                $fecha_arr[] = $this->obtenerFechaEnLetra($fecha->fecha);
                            }
                        }
                        $ev->fechas = $fecha_arr;

                    }
                }
                $data['eventos'] = $eventos;


                return view('usuario/perfil',$data);
            }
        }else{
            Auth::logout();
            return redirect('/');
        }

    }


    public function obtenerFechaEnLetra($fecha){
        $dia= $this->conocerDiaSemanaFecha($fecha);
        $num = date("j", strtotime($fecha));
        $anno = date("Y", strtotime($fecha));
        $mes = array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');
        $mes = $mes[(date('m', strtotime($fecha))*1)-1];
        return $dia.', '.$num.' de '.$mes.' del '.$anno;
    }

    public function conocerDiaSemanaFecha($fecha) {
        $dias = array('Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado');
        $dia = $dias[date('w', strtotime($fecha))];
        return $dia;
    }

}