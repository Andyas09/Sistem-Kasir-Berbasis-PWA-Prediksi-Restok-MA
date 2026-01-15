<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Produk;

class Kategori extends Authenticatable
{
    protected $table = 'kategori';
    protected $primaryKey = 'id';
    protected $fillable = ['nama_kategori'];
    public function produk()
    {
        return $this->hasMany(Produk::class, 'kategori_id');
    }
    
}