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
use Illuminate\Support\Facades\DB;
use App\Paquete AS Paquete;


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
    
    
    public function apartar($id,Evento $evento){
        $data['id'] = $id;
        $data['evento'] = $evento->find($id);

        $fechas = Eventofecha::where(['idevento'=>$id])->get();
        if(isset($fechas)){
            foreach ($fechas as $fecha){
                $fecha_arr[] = array("fecha"=>$fecha->fecha, "label"=>$this->obtenerFechaEnLetra($fecha->fecha));
            }
        }
        $data['fechas'] = $fecha_arr;


        return view('usuario/eventoform',$data);
        
    }


    public function getseccion(Request $request){
        if($request->ajax()){
            $id = $request->input('id');

            $secciones = DB::table('view_tickets')->select(['idseccion','seccion'])->where([
                ['idevento', '=', $id ]
            ])->groupBy(['idseccion','seccion'])->get();


            return response()->json([
                'secciones' => $secciones,
                'getdata'=>true
            ]);


        }

    }
    
    public function getpaquetes(Request $request){
        if($request->ajax()){
            $id = $request->input('id');
            $seccion = $request->input('seccion');

            $paquetes = DB::table('view_tickets')->select(['idpaquete','paquete'])->where([
                ['idevento', '=', $id,'and' ],['idseccion','=',$seccion]
            ])->groupBy(['idpaquete','paquete'])->get();




            return response()->json([
                'paquetes' => $paquetes,
                'getdata'=>true
            ]);


        }
    }

    public function getavailable(Request $request){
        if($request->ajax()){
            $id = $request->input('id');
            $seccion = $request->input('seccion');
            $paquete = $request->input('paquete');
            $fecha = $request->input('fecha');

            $tickets_available = DB::table('view_tickets')->select(['id','idstatus','estatus','folio','precio','divisa','personas','seccion','paquete'])->where([
                ['fecha','=',$fecha,'and'],['idevento', '=', $id,'and' ],['idseccion','=',$seccion,'and'],['idpaquete','=',$paquete,'and'],['idstatus','=',1]
            ])->get();

            return response()->json([
                'available' => $tickets_available->count(),
                'ticket' =>$tickets_available[0],
                'getdata'=>true
            ]);
        }
    }

    public function payform(Request $request){
        
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