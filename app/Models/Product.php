<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Department;

class Product extends Model
{
    protected $fillable = [
    'name', // mass asignment
    'category',
    'description',
    'contraindications',
    'price',
    'status_id',
    'department_id',
    'product_id',
    'dealer_id'
];
    use HasFactory;

    public function departments() {
        return $this->belongsToMany(Department::class,'department_product');
    }

    public function categories() {
        return $this->hasOne('App\Category');
    }

    public function order() {
        return $this->belongsTo('App\Order');
    }
}
