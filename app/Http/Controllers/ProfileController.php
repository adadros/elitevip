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

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function view(){
        if(Auth::user()->isActivo(Auth::id())) {
            if (Auth::user()->hasAnyRole(Auth::id(), 'Admin')) {
                return redirect('/admin');
            } else {
                return view('usuario/perfil');
            }
        }else{
            Auth::logout();
            return redirect('/');
        }

    }

}