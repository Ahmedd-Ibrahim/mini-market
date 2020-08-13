<?php

namespace App\model;

use App\Category;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
class Product extends Model
{
    use Translatable;
    protected $guarded = [];
    public $translatedAttributes = ['name', 'description'];

    /* begin Relations */
    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function orders(){
        return $this->belongsToMany(Order::class,'product_order');
    }

    /* End Relations */
}
