<?php
/**
 * Created by PhpStorm.
 * User: Adad
 * Date: 24/12/2020
 * Time: 08:24 AM
 */
namespace App\Http\Controllers;

use Conekta\Conekta;
use Illuminate\Http\Request;

class PaymentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function view(){


        $version = \Conekta\Conekta::$pluginVersion;
        //\Conekta\Conekta::setApiKey
        $data['version'] = $version;

        return view('usuario/pago',$data);
    }

}