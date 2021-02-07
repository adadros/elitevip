<?php
/**
 * Created by PhpStorm.
 * User: Adad
 * Date: 24/12/2020
 * Time: 08:24 AM
 */
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Conekta;

class PaymentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function procesa_pago(Request $request){
        if($request->ajax()){


            $brand = $request->input('brand');
            $card = $request->input('card');
            $descripcion = $request->input('descripcion');
            $invitados = $request->input('invitados');
            $productos = $request->input('productos');
            $name = $request->input('name');
            $email = session('profile')['email'];
            $tipo = $request->input('tipo');
            $total = $request->input('total');
            $divisa = $request->input('divisa');
            $tok = $request->input('tok');
            $telefono = $request->input('telefono');
            $detalles = $request->input('detalles');
            $uid = session('profile')['uid'];

            $conekta_payment = new Conekta\ConektaPayment();
            $orden = [
                'amount'      => $total * 100,
                'currency'    => $divisa,
                'description' => $descripcion,
                'customer_info'     => [
                    'name'  => $name,
                    'phone' => $telefono,
                    'email' => $email
                ],
                'line_items' => $productos
            ];
            $tokenTarjeta = $tok;

            /**conekta apply pay*/
            //$res = $conekta_payment->conTarjeta($orden, $tokenTarjeta);
            //$ordenid = $res['conekta']['id'];

            $res['error'] = false;
            $ordenid='ord_2pCjBsExEjWMce1CV';



            $band=false;
            /**valido que los boletos elegidos esten disponibles*/
            if($band) {

                if (!$res['error']) {
                    DB::beginTransaction();
                    try {
                        if (isset($detalles)) {

                            DB::insert('insert into pagos (uid,idorden,monto,divisa,created_at,updated_at) values (?,?,?,NOW(),NOW())', [
                                $uid,
                                $ordenid,
                                $total,
                                $divisa
                            ]);

                            foreach ($detalles as $detalle) {
                                $cantidad = count($detalle);
                                $ticket_detalle = $detalle[0];
                                DB::insert('insert into user_pagos (uid, idorden, idevento, idseccion, idpaquete, cantidad, precio, created_at, updated_at) values (?,?,?,?,?,?,?,NOW(),NOW())', [
                                    $uid,
                                    $ordenid,
                                    $ticket_detalle['idevento'],
                                    $ticket_detalle['idseccion'],
                                    $ticket_detalle['idpaquete'],
                                    $cantidad,
                                    $ticket_detalle['precio']
                                ]);


                            }

                            if (isset($invitados)) {
                                foreach ($invitados as $invitado) {
                                    //id, uid, folio, nombre, created_at, updated_at
                                    DB::insert('insert into user_tickets (uid, idorden, idfolio, folio, nombre, created_at, updated_at) values (?,?,?,?,?,NOW(),NOW())', [
                                        $uid,
                                        $ordenid,
                                        intval($invitado['id']),
                                        trim($invitado['folio']),
                                        strtoupper($invitado['invitado'])
                                    ]);

                                    DB::update('update tickets set status=? where id=?', [
                                        2,
                                        intval($invitado['id'])
                                    ]);


                                }
                            }

                        }

                        DB::commit();
                    } catch (\Exception $e) {
                        DB::rollBack();
                        throw  $e;
                    } catch (\Throwable $e) {
                        DB::rollBack();
                        throw $e;
                    }
                }

                return response()->json([
                    'res' => $res['conekta']['id'],
                    'result' => $res,
                    'detalles' => $detalles,
                    'getdata' => true,

                ]);
            }


            return response()->json(
              [
                  'res' => $this->validateTicketsAvailable($invitados),
                  'invitados'=>$invitados,
                  'getdata' => true
              ]
            );

            /*
            $id = $request->input('id');
            $seccion = $request->input('seccion');

            $paquetes = DB::table('view_tickets')->select(['idpaquete','paquete'])->where([
                ['idevento', '=', $id,'and' ],['idseccion','=',$seccion]
            ])->groupBy(['idpaquete','paquete'])->get();

            */








        }
    }
    public function validateTicketsAvailable($tickets_values){
        $isAvilable=true;
        $in_ids = [];
        $data_test = [];
        if(isset($tickets_values)){
            foreach ($tickets_values as $ticket){
                $in_ids[] = intval($ticket['id']);
            }
        }
        $in_ids = array_unique($in_ids);
        if(count($in_ids)>0){

            $rows = DB::table('tickets')->whereIn('id', $in_ids)
                ->where('idstatus',1)
                ->get();

            $data_test['rows'] = $rows;
            $data_test['ids'] = $in_ids;


        }


        return $data_test;
    }



}