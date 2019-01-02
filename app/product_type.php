<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class product_type extends Model
{
    protected $table = 'product_types';
    //1-n
    public function product_type_item(){
        return $this->hasMany('App\product_type_item','id_type',id);
    }
    public function product(){
        return $this->hasManyThrough('App\product', 'App\product_type_item','id_type','id_type_item','id');
    }
}
