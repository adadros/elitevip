<?php
/**
 * Created by PhpStorm.
 * User: Adad
 * Date: 30/12/2020
 * Time: 11:57 PM
 */
namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;

class EmailAprobado extends Mailable{
    use Queueable, SerializesModels;

    public $detalle;
    public function __construct($data)
    {
        $this->detalle = $data;

    }

    public function build(Request $request){


        /*return $this->subject($this->detalle['subject'])
            ->view('mails.aprobado')
            ->from($this->detalle['from'], $this->detalle['from']);
*/
        return $this->view('mails.aprobado')
            ->text('mails.aprobado_plain')
            ->subject($this->detalle['subject'])
            ->to($this->detalle['to']);


        /**
        ->text('mails.aprobado_plain')
        ->attach(public_path('/images').'/elitevip.jpg', [
        'as' => 'elitevip.jpg',
        'mime' => 'image/jpeg',
        ])->to('adad_rosado@animotion.com.mx');
         */


    }


    



}