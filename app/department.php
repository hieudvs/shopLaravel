<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class department extends Model
{
    protected $table = 'departments';

    //1-n : Khoa ngoai nhieu - id b 1
    public function User(){
    	return $this->hasMany('App\User','id_department','id');
    }
}
