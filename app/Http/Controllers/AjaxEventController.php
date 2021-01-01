<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;


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


    public function guardar(Request $request){

        if($request->ajax()){
            $titulo = $request->input('titulo');
            $portada = $request->input('portada');
            $descripcion = $request->input('descripcion');
            $fechas = $request->input('fechas');
            $fecha_format = array();
           


            return response()->json([
                'message'=>'Prueba de guardar datos',
                'req'=>array($titulo,$portada,$descripcion,$fechas,$fecha_format),
                'saved'=>true

            ]);
        }

    }

}
