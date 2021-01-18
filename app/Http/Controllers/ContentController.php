<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContentController extends Controller
{
    public function home(){
        return view('welcome');
    }

    public function contacto(){
        return view('content/contacto');
    }

    public function colaboradores(){
        return view('content/colaboradores');
    }

    public function bolsa(){
        return view('content/bolsa');
    }

    public function proveedores(){
        return view('content/proveedores');
    }

}
