<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Opname;
use App\Models\Produk;
class OpnameDetail extends Authenticatable
{
    protected $table = 'opname_detail';
    protected $primaryKey = 'id';
    protected $fillable = 
    [
        'stok_id',
        'produk_id',
        'stok_sistem',
        'stok_fisik',
        'terjual',
        'rusak',
    ];
    public function opname()
    {
        return $this->hasMany(Opname::class, 'stok_id');
    }
    public function produk()
    {
        return $this->hasMany(Produk::class, 'produk_id');
    }
    
    
}