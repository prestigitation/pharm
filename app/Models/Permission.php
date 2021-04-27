<?php

namespace App\Models;
use App\Models\User;
use App\Models\Role;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable=['name','roles'];
    use HasFactory;

    public function roles() {
        return $this->belongsToMany(Role::class);
    }
}
