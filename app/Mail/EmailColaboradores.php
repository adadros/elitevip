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

class EmailColaboradores extends Mailable{
    use Queueable, SerializesModels;

    public $detalle;
    public function __construct($data)
    {
        $this->detalle = $data;
    }

    public function build(Request $request){


        return $this->view('mails.colaboradores')
            ->text('mails.colaboradores_plain')
            ->subject($this->detalle['subject'])
            ->to($this->detalle['to']);


    }






}