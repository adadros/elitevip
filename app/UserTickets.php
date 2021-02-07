<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserTickets extends Model
{
    protected $table = 'user_tickets';
    protected $fillable = ["uid","folio","nombre"];

}