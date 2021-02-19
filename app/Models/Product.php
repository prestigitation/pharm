<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', // mass asignment
    'category',
    'description',
    'contraindications',
    'price'
];
    use HasFactory;

    public function departments() {
        return $this->belongsToMany('App\Department');
    }

    public function categories() {
        return $this->hasOne('App\Category');
    }

    public function order() {
        return $this->belongsTo('App\Order');
    }
}
