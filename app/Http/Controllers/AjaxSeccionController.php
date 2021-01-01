<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Seccion as Seccion;

class AjaxSeccionController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth','auth.admin']);
    }



    public function guardar(Request $request, Seccion $seccion){

        if($request->ajax()){

            $validacion = Validator::make(
                $request->all(),[
                    'tipo' => 'required',
                    'nombre' => 'required',                    
                ]
            );
            if($validacion->passes()){

                $seccion->nombre = $request->input('nombre');
                $seccion->tipo = $request->input('tipo');
                $seccion->save();

                return response()->json([
                    'message'=>'La sección de '.$seccion->nombre.' se ha guardado con éxito',
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
                    'tipo' => 'required'
                ]
            );
            if($validacion->passes()){

                $id= $request->input('id');
                Seccion::whereId($id)->update([
                    'nombre' => $request->input('nombre'),
                    'tipo' => $request->input('tipo'),
                ]);

                return response()->json([
                    'message'=>'La sección se ha actualizado con éxito',
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
                Seccion::whereId($id)->delete();

                return response()->json([
                    'message'=>'La sección se ha eliminado',
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
