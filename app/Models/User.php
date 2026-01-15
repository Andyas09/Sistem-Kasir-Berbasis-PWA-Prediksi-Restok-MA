<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Role;

class User extends Authenticatable
{
    protected $fillable = [
        'nama',
        'username',
        'email',
        'password',
        'role_id',
        'status'
    ];

    protected $hidden = [
        'password',
    ];
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
    public function isAdmin()
    {
        return $this->role_id === 1;
    }

    public function isKasir()
    {
        return $this->role_id === 2;
    }


}
