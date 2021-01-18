<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\ViewUserRole as ViewUserRole;

class User extends Authenticatable
{
    use Notifiable;


    public function userRol(){
        return $this->belongsToMany('App\Role','App\UserRole','uid','id');
    }

    public function userPerfil(){
        return $this->hasOne('App\Perfil','uid','id');
    }


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function isActivo($id){
       $activo = $this::whereId($id)->where('activo',1)->get()->first();
       return null != $activo;
    }

    public function hasAnyRole($id,$role){
        $result = ViewUserRole::whereId($id)->where('descripcion',$role)->get()->first();
        return null != $result;

    }


}
