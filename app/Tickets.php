<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tickets extends Model
{
    protected $table = 'tickets';
    protected $fillable = ["folio","idpaquete","idseccion","divisa","precio","idstatus","fecha","idevento"];



}