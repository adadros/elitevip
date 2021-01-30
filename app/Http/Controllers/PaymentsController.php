<?php
/**
 * Created by PhpStorm.
 * User: Adad
 * Date: 24/12/2020
 * Time: 08:24 AM
 */
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Conekta;

class PaymentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function procesa_pago(Request $request){
        if($request->ajax()){

            return response()->json([
                'paquetes' => $request->all(),
                'getdata'=>true
            ]);

            /*
            $conekta_payment = new Conekta\ConektaPayment();

            $orden = [
                'amount'      => 100 * 100,
                'currency'    => 'mxn',
                'description' => 'Boletos de Cine CineChido',
                'customer_info'     => [
                    'name'  => 'Daniel Salcedo',
                    'phone' => '',
                    'email' => 'laboratorio@backapp.com.mx'
                ],
                'line_items' => [
                    [
                        'name'        => 'Pantalla',
                        'description' => 'Pantalla 4k para jugar juegos jugables chidos perrones :v',
                        'unit_price'  => 100 * 100,
                        'quantity'    => 1,
                        'sku'         => 'PANTALLA4k0001'
                    ]
                ]
            ];
            $tokenTarjeta = 'tok_test_visa_4242';

            */
            
            


            //$conekta_payment->conTarjeta();

            /*
            $id = $request->input('id');
            $seccion = $request->input('seccion');

            $paquetes = DB::table('view_tickets')->select(['idpaquete','paquete'])->where([
                ['idevento', '=', $id,'and' ],['idseccion','=',$seccion]
            ])->groupBy(['idpaquete','paquete'])->get();

            */



            /*

            return response()->json([
                'paquetes' => $paquetes,
                'getdata'=>true
            ]);*/


        }
    }



}