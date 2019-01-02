<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class bill extends Model
{
    protected $table = 'bills';
    //1 - n
    public function bill_detail(){
        return $this->hasMany('App\bill_detail','id_bill','id');
    }
    // 1-1
    public function customer(){
        return $this->belongsTo('App\customer','id_customer','id');
    }
}
