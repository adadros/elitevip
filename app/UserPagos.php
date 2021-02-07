<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class UserPagos extends Model
{
    protected $table = 'user_pagos';
    protected $fillable = ['uid','idorden','idevento','idseccion','idpaquete','cantidad','precio'];
}