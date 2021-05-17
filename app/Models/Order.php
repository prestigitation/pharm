<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable=[
        'user_id',
        'product_id',
        'quantity',
        'buy_price'
    ];

    public function products() {
        return $this->hasMany('App\Product');
    }
    public function users() {
        return $this->hasOne('App\User');
    }
}
