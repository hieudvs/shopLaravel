<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

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

    //1-1
    public function department(){
    	return $this->belongsTo('App\department','id_department','id');
    }

    //1-n :
    public function order_status(){
    	return $this->belongsTo('App\order_status','id_user ','id');
    }

    //1-n
    public function product(){
    	return $this->hasMany('App\product','id_user','id');
    }
}
