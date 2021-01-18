<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{
    protected $table = 'perfil';

    public function user(){
        return $this->belongsTo('App\User','id','uid');
    }

}
