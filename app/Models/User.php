<?php

namespace App\Models;

use App\Models\Role;
use App\Models\Department;
use App\Models\Permission;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function permissions() {
        return $this->belongsToManyThrough(Permission::class,Role::class);
    }


    public function department() {
        return $this->belongsTo('App\Department');
    }

    public function roles() {
        return $this->belongsToMany(Role::class);
    }

    public static function boot()
    {
        parent::boot();
        Department::creating(function ($user) {
          $user->roles()->attach(1);
     });
    }
}
