<?php

namespace App\Models;

use App\Models\User;
use App\Models\Permission;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['name','permissions'];

    public function users() {
        return $this->belongsToMany(User::class);
    }

    public function permissions() {
        return $this->belongsToMany(Permission::class);
    }

    public static function hasPermission(Role $role, Permission $permission) {
        foreach($role->permissions->toArray() as $perm) {
            if($perm['name'] == $permission->name) {
                return true;
            } else continue;
        }
        return false;
    }
}
