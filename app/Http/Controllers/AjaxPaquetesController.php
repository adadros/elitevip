<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Paquete as Paquete;



class AjaxPaquetesController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth','auth.admin']);
    }


   
    public function guardar(Request $request, Paquete $paquete){

        if($request->ajax()){

            $validacion = Validator::make(
                $request->all(),[
                    'nombre' => 'required',
                    'divisa' => 'required',
                    'precio' => 'required',
                    'personas' => 'required',
                ]
            );
            if($validacion->passes()){

                $paquete->nombre = $request->input('nombre');
                $paquete->divisa = $request->input('divisa');
                $paquete->precio = $request->input('precio');
                $paquete->personas = $request->input('personas');
                $paquete->save();

                return response()->json([
                    'message'=>'El paquete de '.$paquete->nombre.' se ha guardado con éxito',
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
        if($request->ajax()){

            $validacion = Validator::make(
                $request->all(),[
                    'nombre' => 'required',
                    'divisa' => 'required',
                    'precio' => 'required',
                    'personas' => 'required',
                ]
            );
            if($validacion->passes()){

                $id= $request->input('id');
                Paquete::whereId($id)->update([
                    'nombre' => $request->input('nombre'),
                    'divisa' => $request->input('divisa'),
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
        }
    }



}
