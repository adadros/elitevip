<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Paquete as Paquete;
use App\Lugar as Lugar;
use App\Seccion as Seccion;
use App\ViewUserProfile as ViewUserProfile;



class AdminController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth','auth.admin']);
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

    public function panel(){
        $data['profile'] = $this->getProfile();
        return view('admin/dashboard',$data);
    }

    public function eventos(){
        $data['profile'] = $this->getProfile();
        return view('admin/eventos',$data);
    }

    public function pagos(){
        $data['profile'] = $this->getProfile();
        return view('admin/pagos',$data);
    }

    /**usuarios routes*/
    public function usuarios(ViewUserProfile $view_profile){
        $data['profile'] = $this->getProfile();
        $data['perfiles'] = $view_profile->all(['id','email','nombre','apellido','activo','descripcion']);
        return view('admin/usuarios',$data);
    }

    public function newUsuario(){
        $data['profile'] = $this->getProfile();
        $data['editable'] = false;
        return view('admin/nuevousuario',$data);
    }

    public function editUsuario($id,  ViewUserProfile $view_profile){
        $data['profile'] = $this->getProfile();
        $data['id'] = $id;
        $data['perfil'] = $view_profile->find($id);
        $data['editable'] = true;
        return view('admin/nuevousuario',$data);
    }


    public function perfil(){
        $data['profile'] = $this->getProfile();
        return view('admin/perfil',$data);
    }

    public function opciones(){
        $data['profile'] = $this->getProfile();
        return view('admin/opciones',$data);
    }

    public function newEvento(Seccion $seccion, Paquete $paquete){
        $data['profile'] = $this->getProfile();
        $data['secciones'] = $seccion->all();
        $data['paquetes'] = $paquete->all();
        return view('admin/nuevoevento',$data);
    }


    /**creando las url para secciones*/
    public function secciones(Seccion $seccion){
        $data['profile'] = $this->getProfile();

        $secciones = DB::table('secciones as s')
            ->select(['s.id','s.nombre','lugares.nombre as tipo'])
            ->join('lugares', 'lugares.id', '=', 's.tipo')
            ->get();

        $data['secciones'] = $secciones;
        return view('admin/secciones',$data);
    }
    public function newSeccion(Lugar $lugar){
        $data['profile'] = $this->getProfile();
        $data['editable'] = false;
        $data['lugares'] = $lugar->all();
        return view('admin/nuevaseccion',$data);
    }
    public function editSeccion($id, Seccion $seccion, Lugar $lugar){
        $data['profile'] = $this->getProfile();
        $data['id'] = $id;
        $data['seccion'] = $seccion->find($id);
        $data['lugares'] = $lugar->all();
        $data['editable'] = true;
        return view('admin/nuevaseccion',$data);
    }




    /**creando urls para los paquetes*/

    public function paquetes(Paquete $paquete){
        $data['profile'] = $this->getProfile();
        $data['paquetes'] = $paquete->all();
        return view('admin/paquetes',$data);
    }

    public function newPaquete(){
        $data['profile'] = $this->getProfile();
        $data['editable'] = false;
        return view('admin/nuevopaquete',$data);
    }

    public function editPaquete($id, Paquete $paquete){
        $data['profile'] = $this->getProfile();
        $data['id'] = $id;
        $data['paquete'] = $paquete->find($id);
        $data['editable'] = true;
        return view('admin/nuevopaquete',$data);
    }


}
