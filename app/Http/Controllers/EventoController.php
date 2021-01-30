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
            $tid = str_replace("-", "", $fecha).$seccion.$paquete;

            $tickets_available = DB::table('view_tickets')->select(['id','idstatus','estatus','folio','precio','divisa','personas','seccion','paquete','idseccion','idpaquete'])->where([
                ['fecha','=',$fecha,'and'],['idevento', '=', $id,'and' ],['idseccion','=',$seccion,'and'],['idpaquete','=',$paquete,'and'],['idstatus','=',1]
            ])->get();

            /**construyendo template*/

            $ticket_template = '
                    
                    <div class="card op-white-hi border-dashed bd-lightTaupe">
                        <div class="card-header bg-darkTaupe fg-white p-0">
                            <div class="badge cycle" style="background:transparent;"><a onclick="removeTicket(\''.$tid.'\')" role="button" class="button bg-red-hover large bg-darkRed fg-white cycle"><span class="mif-bin mif-2x"></span></a></div>
                            <div class="row list-ticket bg-black fg-lightTaupe pos-relative mx-0" style="background-image:url('.asset('images/cintilla.gif').'); height:30px;">

                            </div>
                        </div>
                        <div class="card-content content-ticket px-1" style="background-image:url('.asset('images/bgbodycard200.gif').')">

                            <div class="row fg-black p-2 f-size-14">
                                <div class="cell-md-12 mt-1">
                                    Fecha: <span class="p-1 px-2 op-white-low  bg-green"> '.$this->obtenerFechaEnLetra($fecha).' </span>
                                </div>
                                <div class="cell-md-12 mt-1">
                                    Seccion: <span class="p-1 px-2 op-white-low">'.$tickets_available[0]->seccion.'</span>
                                </div>
                                <div class="cell-md-12 mt-1">
                                    Paquete: <span class="p-1 px-2 op-white-low">'.$tickets_available[0]->paquete.'</span>
                                </div>
                                <div class="cell-md-12 mt-1">
                                    Precio: <span class="p-1 px-2 op-white-low">$'.$tickets_available[0]->precio.' '.$tickets_available[0]->divisa.'</span>
                                </div>

                                <div class="cell-md-12 mt-1">
                                    Aplica para: <span class="p-1 px-2 op-white-low"> '.$tickets_available[0]->personas.' persona(s)</span>
                                </div>

                            </div>
                        </div>
                        <div class="card-footer bg-black fg-lightTaupe">
                            <div class="footer-ticket form-group text-center">
                                <div>
                                    <label>¿Cuantos tickets quieres?</label>
                                    <input id="'.$tid.'_cantidad" type="number" data-max-value="'.$tickets_available->count().'" data-step="1" data-min-value="1" data-role="spinner" value="1">
                                </div>  
                            </div>

                        </div>
                    </div>
                ';


            /**construyendo template*/

            return response()->json([
                'available' => $tickets_available->count(),
                'id'=>$tid,
                'template'=>$ticket_template,
                'ticket' =>$tickets_available[0],
                'getdata'=>true
            ]);
        }
    }

    public function payform(Request $request){
        if($request->ajax()) {

            /*DB::transaction(function() use ($request, &$tickets_arr ) {
                $id = $request->input('id');
                $tickets = $request->input('tickets');
                foreach ($tickets as $ticket) {
                        $cantidad = $ticket['cant'];
                        $fecha = $ticket['fecha'];
                        $seccion = $ticket['ticket']['idseccion'];
                        $paquete = $ticket['ticket']['idpaquete'];
                        $tickets_arr[] = DB::table('view_tickets')->select(['id', 'idstatus', 'estatus', 'folio', 'precio', 'divisa', 'personas', 'seccion', 'paquete'])->where([
                            ['fecha', '=', $fecha, 'and'], ['idevento', '=', $id, 'and'], ['idseccion', '=', $seccion, 'and'], ['idpaquete', '=', $paquete, 'and'], ['idstatus', '=', 1]
                        ])->take(intval($cantidad))->get()->toArray();

                }
            });*/
                        
            $id = $request->input('id');
            $seccion = $request->input('seccion');
            $paquete = $request->input('paquete');
            $fecha = $request->input('fecha');
            $cantidad = $request->input('cantidad');


            $tickets_available = DB::table('view_tickets')->select(['id', 'idstatus', 'estatus', 'folio', 'precio', 'divisa', 'personas', 'seccion', 'paquete'])->where([
                ['fecha', '=', $fecha, 'and'], ['idevento', '=', $id, 'and'], ['idseccion', '=', $seccion, 'and'], ['idpaquete', '=', $paquete, 'and'], ['idstatus', '=', 1]
            ])->take(intval($cantidad))->get();


            return response()->json([
                'ticket' => $tickets_available,
                'id'=>$id,
                'fecha'=>$fecha,
                'seccion'=>$seccion,
                'paquete'=>$paquete,
                'profile' => session('profile')['nombre'].' '.session('profile')['apellido'],
                //'cantidad' => $cantidad,
                'getdata' => true
            ]);
        }

    }

    public function getTicketsAvailable($id,$fecha,$seccion,$paquete,$cantidad){



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