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
            session(['profile'=>$this->getProfile()]);
            if (Auth::user()->hasAnyRole(Auth::id(), 'Admin')) {
                return redirect('/admin');
            } else {


                $eventos = $evento->all();
                $data['eventos'] = $eventos;
                return view('usuario/perfil',$data);
            }
        }else{
            Auth::logout();
            return redirect('/');
        }

    }




}