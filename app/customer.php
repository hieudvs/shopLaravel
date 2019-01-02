<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class customer extends Model
{
    protected $table = 'customers';
    //1-n
    public function bill(){
    	return $this->hasMany('App\bill','id_customer','id');
    }
}
