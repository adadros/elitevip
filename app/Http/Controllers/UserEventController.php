<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Evento as Evento;

class UserEventController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth']);
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

   
    public function eventos(Evento $evento){
        $data['profile'] = $this->getProfile();
        $data['eventos'] = $evento->all();
        return view('admin/eventos',$data);
    }
    



}
