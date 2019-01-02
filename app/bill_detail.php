<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class bill_detail extends Model
{
    protected $table = 'bill_details';
    //1-1
    public function product(){
        return $this->belongsTo('App\product','id_product','id');
    }
    //1-1
    public function  bill(){
        return $this->belongsTo('App\bill','id_bill','id');
    }

}
