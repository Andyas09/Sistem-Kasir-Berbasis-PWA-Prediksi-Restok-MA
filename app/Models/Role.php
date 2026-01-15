<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\user;

class Role extends Authenticatable
{
    protected $fillable = ['nama_role'];
}