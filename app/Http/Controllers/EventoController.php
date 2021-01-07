<?php
/**
 * Created by PhpStorm.
 * User: Adad
 * Date: 24/12/2020
 * Time: 08:24 AM
 */
namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Evento as Evento;
use App\EventoFecha as EventoFecha;

class EventoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function view(){
        return view('content/eventos');
    }

    public function detalle($id,Evento $evento){
        $data['id'] = $id;
        $data['evento'] = $evento->find($id);

        $fecha_arr = [];
        $fechas = Eventofecha::where(['idevento'=>$id])->get();
        if(isset($fechas)){
            foreach ($fechas as $fecha){
                $fecha_arr[] = $this->obtenerFechaEnLetra($fecha->fecha);
            }
        }
        $data['fechas'] = $fecha_arr;


        return view('usuario/evento',$data);
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