<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Mail;
use App\Mail\SendEmail;

class MailController extends Controller
{
    public function send(){

        $detalle = [
            'to' => 'adad_rosado@animotion.com.mx',
            'from' => 'adminweb@eliteexperiencevip.com',
            'subject' => "Mensaje de aprobación",
            'title' => "Bienvenido a Elite Experience Vip",
            "body"  => "Hola, Bienvenido a Elite Experience Vip"
        ];

        Mail::send(new SendEmail($detalle));
        //Mail::send(new SendEmail());
    }
}
