<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $guarded = [];
    protected $table = 'clients';
    protected $fillable = ['name','phone','address'];

    /* Begin Relations*/
    public function orders() {
        return $this->hasMany(Order::class);
    }
    /* End Relations*/
}
