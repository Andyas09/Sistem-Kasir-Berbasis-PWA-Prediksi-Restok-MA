<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Kategori;

class Produk extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $table = 'produk';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nama_produk',
        'gambar',
        'kategori_id',
        'harga_jual',
        'warna',
        'ukuran',
        'status',
        'deskripsi',
        'harga_modal',
        'stok',
    ];
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }
    

}
