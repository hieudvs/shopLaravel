<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class product_type_item extends Model
{
    protected $table = 'product_type_items';
    //1-1
    public function product_type(){
        return $this->belongsTo('App\product_type','id_type','id');
    }

}
