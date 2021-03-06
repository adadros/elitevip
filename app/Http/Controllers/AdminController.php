<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Paquete as Paquete;
use App\Lugar as Lugar;
use App\Divisa as Divisa;
use App\Seccion as Seccion;
use App\ViewUserProfile as ViewUserProfile;
use App\ViewTickets as ViewTickets;
use App\Evento as Evento;



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
        return view('admin/dashboard');
    }

    public function eventos(Evento $evento){
        $data['eventos'] = $evento->all();
        return view('admin/eventos',$data);
    }
    public function newEvento(Seccion $seccion, Paquete $paquete, Divisa $divisa){
        $data['editable'] = false;
        $data['secciones'] = $seccion->all();
        $data['paquetes'] = $paquete->all();
        $data['divisas'] = $divisa->all();
        return view('admin/nuevoevento',$data);
    }

    public function editEventos($id,Evento $evento){
        $data['id'] = $id;
        $data['evento'] = $evento->find($id);
        $data['editable'] = true;
        return view('admin/eventos',$data);
    }

    public function tickets($id){
        $tickets_filtered = DB::table('view_tickets as vt')
            ->select(['*'])
            ->whereRaw('vt.idevento = ?',[$id])
            ->get();
        $data['tickets'] = $tickets_filtered;

        return view('admin/tickets',$data);
    }

    public function editTicket($id,  ViewTickets $view_ticket){
        $data['id'] = $id;
        $data['ticket'] = $view_ticket->find($id);
        $data['editable'] = true;
        return view('admin/nuevoticket',$data);
    }



    public function pagos(){
        return view('admin/pagos');
    }

    /**usuarios routes*/
    public function usuarios(ViewUserProfile $view_profile){
        $data['perfiles'] = $view_profile->all(['id','email','nombre','apellido','activo','descripcion']);
        return view('admin/usuarios',$data);
    }

    public function newUsuario(){
        $data['editable'] = false;
        return view('admin/nuevousuario',$data);
    }

    public function editUsuario($id,  ViewUserProfile $view_profile){
        $data['id'] = $id;
        $data['perfil'] = $view_profile->find($id);
        $data['editable'] = true;
        return view('admin/nuevousuario',$data);
    }


    public function perfil(){
        return view('admin/perfil');
    }

    public function opciones(){
        return view('admin/opciones');
    }




    /**creando las url para secciones*/
    public function secciones(){

        $secciones = DB::table('secciones as s')
            ->select(['s.id','s.nombre','lugares.nombre as tipo'])
            ->join('lugares', 'lugares.id', '=', 's.tipo')
            ->get();

        $data['secciones'] = $secciones;
        return view('admin/secciones',$data);
    }
    public function newSeccion(Lugar $lugar){
        $data['editable'] = false;
        $data['lugares'] = $lugar->all();
        return view('admin/nuevaseccion',$data);
    }
    public function editSeccion($id, Seccion $seccion, Lugar $lugar){
        $data['id'] = $id;
        $data['seccion'] = $seccion->find($id);
        $data['lugares'] = $lugar->all();
        $data['editable'] = true;
        return view('admin/nuevaseccion',$data);
    }


    /**creando las url para secciones*/
    public function categorias(){

        return view('admin/categorias');
    }





    /**creando urls para los paquetes*/

    public function paquetes(Paquete $paquete){
        $data['paquetes'] = $paquete->all();
        return view('admin/paquetes',$data);
    }

    public function newPaquete(Divisa $divisa){
        $data['editable'] = false;
        $data['divisas'] = $divisa->all();
        return view('admin/nuevopaquete',$data);
    }

    public function editPaquete($id, Paquete $paquete, Divisa $divisa){
        $data['id'] = $id;
        $data['paquete'] = $paquete->find($id);
        $data['divisas'] = $divisa->all();
        $data['editable'] = true;
        return view('admin/nuevopaquete',$data);
    }


}
