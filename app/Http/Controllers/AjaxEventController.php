<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use App\Evento as Evento;
use App\EventoFecha as EventoFecha;
use App\Tickets as Tickets;


class AjaxEventController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth','auth.admin']);
    }

    public function uploadPortada(Request $request){
        $validacion = Validator::make(
            $request->all(),[
                'portada' => 'required|image|mimes:jpeg,png,jpg,gif|max:6024',
            ]
        );
        if($validacion->passes())
        {
            $image = $request->file('portada');
            $img_name = uniqid('imG') . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads'),$img_name);

            return response()->json([
                'message' => "imagen subida exitosamente",
                'upload_image' => '
                    <input type="hidden" id="img_portada" name="img_portada" value="'.$img_name.'" >
                    <div data-role="panel"
                                data-title-icon="<span class=\'mif-image\'></span>"
                                data-title-caption="<img data-container=\'preview_portada\' data-btn=\'uploadPortada\' data-name=\'portada\' data-image=\''.$img_name.'\' class=\'img-thumbnail-responsive\' src=\'/public/uploads/'.$img_name.'\' > Imagen portada"
                                data-collapsible="true"
                                data-custom-buttons="BotonUpload">
                                <div class="img-container thumbnail selected">
                                    <img class="img-responsive" src="/public/uploads/'.$img_name.'">
                                </div>        
                    </div>',
                'only_name' => $img_name,
                'error' => false
            ]);

        }
        else
        {
            return response()->json([
                'message' => $validacion->errors()->all(),
                'upload_image' => '',
                'error' => true
            ]);
        }

    }

    public function deleteImage(Request $request){

        if($request->ajax()){

            if( $this->validate($request,["imagen" => "required", ]) )
            {
                $del_path = public_path("uploads/".$request->input('imagen'));
                if(File::exists($del_path)) {
                    File::delete($del_path);
                }

                return response()->json([
                    'message'=>'La imagen ha sido eliminada',
                    'req'=>$request->input('imagen'),
                    'deleted'=>true
                ]);

            }else{
                return response()->json([
                    'message'=>'La imagen no existe',
                    'deleted'=>false
                ]);
            }


        }


    }


    public function guardar(Request $request, Evento $evento){

        if($request->ajax()){
            $validacion = Validator::make(
                $request->all(),[
                    'titulo' => 'required',
                    'portada' => 'required',
                    'descripcion' => 'required',
                    'fechas' => 'required',
                    'tickets' => 'required',
                ]
            );

            if($validacion->passes()) {

                $fechas = $request->input('fechas');
                $tickets = $request->input('tickets');

                DB::beginTransaction();
                try {

                    $evento->titulo = $request->input('titulo');
                    $evento->portada = $request->input('portada');
                    $evento->descripcion = $request->input('descripcion');
                    $evento->save();
                    $id_evento = $evento->id;

                    $ticket_count = Tickets::max('id') + 1;
                    if (isset($fechas)) {
                        foreach ($fechas as $fecha) {
                            //eventos
                            DB::insert('insert into evento_fechas (idevento,fecha,created_at,updated_at) values (?,?,NOW(),NOW())',[$id_evento,$fecha]);

                            if (isset($tickets)) {
                                foreach ($tickets as $ticket) {
                                    $cant = intval($ticket['cantidad']);
                                    if ($cant > 1) {
                                        for ($i = 0; $i < $cant; $i++) {
                                            $folio = str_replace('-', '', $fecha) . str_pad($id_evento.$ticket['seccion'] . $ticket['paquete'],6,'0',STR_PAD_LEFT) . str_pad($ticket_count, 8,'0',STR_PAD_LEFT);
                                            DB::insert('insert into tickets (folio,idpaquete,idseccion,divisa,precio,idstatus,fecha,idevento,created_at,updated_at) values (?,?,?,?,?,?,?,?,NOW(),NOW())',
                                                [
                                                    $folio,
                                                    intval($ticket['paquete']),
                                                    intval($ticket['seccion']),
                                                    trim($ticket['divisa']),
                                                    $ticket['precio'],
                                                    1,
                                                    $fecha,
                                                    $id_evento
                                                ]
                                            );
                                            $ticket_count++;
                                        }
                                    } else {
                                        $folio = str_replace('-', '', $fecha) . str_pad($id_evento.$ticket['seccion'] . $ticket['paquete'],6,'0',STR_PAD_LEFT) . str_pad($ticket_count, 8,'0',STR_PAD_LEFT);
                                        DB::insert('insert into tickets (folio,idpaquete,idseccion,divisa,precio,idstatus,fecha,idevento,created_at,updated_at) values (?,?,?,?,?,?,?,?,NOW(),NOW())',
                                            [
                                                $folio,
                                                intval($ticket['paquete']),
                                                intval($ticket['seccion']),
                                                trim($ticket['divisa']),
                                                $ticket['precio'],
                                                1,
                                                $fecha,
                                                $id_evento
                                            ]
                                        );
                                        $ticket_count++;
                                    }
                                }
                            }

                        }
                    }

                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollBack();
                    throw  $e;
                } catch (\Throwable $e) {
                    DB::rollBack();
                    throw $e;
                }


                return response()->json([
                    'message' => 'Lo boletos del evento se han generado, los puedes visualizar en el menú de tickets',
                    'fechas' => $fechas,
                    'saved' => true
                ]);
            }else{
                return response()->json([
                    'message' => $validacion->errors()->all(),
                    'saved' => false
                ]);
            }
        }

    }
    public function eliminar(Request $request){
        if($request->ajax()){

            $validacion = Validator::make(
                $request->all(),[
                    'id' => 'required',
                ]
            );
            if($validacion->passes()){

                //$id= $request->input('id');
                //Paquete::whereId($id)->delete();


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
        }
    }

}
