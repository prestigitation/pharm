<?php

namespace App\Models;

use App\Models\User;
use App\Models\Permission;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    public function users() {
        return $this->belongsToMany('App\User');
    }

    public function permissions() {
        return $this->hasMany('App\Permission');
    }
}
