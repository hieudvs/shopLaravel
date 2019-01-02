<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class order_status extends Model
{
    protected $table = 'order_status';

    //1-1 :
    public function User(){
    	return $this->belongsTo('App\User','id_user ','id');
    }
}
