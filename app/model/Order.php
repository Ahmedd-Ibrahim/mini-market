<?php

namespace App\model;


use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
protected $fillable = ['total_price'];

/* Begin Relations */
    public function client(){
        return $this->belongsTo(Client::class);
    }

    public function products(){
        return $this->belongsToMany(Product::class,'product_order')->withPivot('quantity');
    }
/* End  Relations */
}
