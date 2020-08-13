<?php

namespace App;

use App\model\Product;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;

class Category extends Model
{
    use Translatable;

    protected $guarded = [];
    public $translatedAttributes   = ['name'];



    /* Begin  Relation */
    public function products(){
        return $this->hasMany(Product::class);
    }
    /* End  Relation */
}
