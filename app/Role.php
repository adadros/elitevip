<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;


class Role extends Model
{
    protected $table = 'roles';

    public function roleUser(){
        return $this->belongsToMany('App\UserRole','rid','id');
    }


}