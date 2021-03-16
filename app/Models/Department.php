<?php

namespace App\Models;

use App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;
    // поля для массового присваивания
    protected $fillable = ['city','address','chief','status_id','product_id','department_id','dealer_id'];

    public function users() {
        return $this->hasMany('App\User');
    }

    public function products() {
        return $this->belongsToMany(Product::class);
    }

    public static function boot()
    {
        parent::boot();
        Department::deleting(function ($department) {
          $department->products()->delete();
     });
    }
}
