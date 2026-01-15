<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\User;
use App\Models\OpnameDetail;

class Opname extends Authenticatable
{
    protected $table = 'stok';
    protected $primaryKey = 'id';
    protected $fillable = 
    [
        'tanggal',
        'nama_sesi',
        'user_id',
        'input_type',
    ];
    public function user()
    {
        return $this->hasMany(User::class, 'id');
    }
    public function opname()
    {
        return $this->hasMany(OpnameDetail::class, 'stok_id');
    }
}