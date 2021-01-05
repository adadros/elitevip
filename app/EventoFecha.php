<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventoFecha extends Model
{
    protected $table = 'evento_fechas';
    protected $fillable = ['idevento','fecha'];


}