<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Transaksi;
use App\Models\Produk;

class Transaksi_detail extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $table = 'transaksi_detail';
    protected $primaryKey = 'id';
    protected $fillable = [
        'transaksi_id',
        'no_invoice',
        'struk',
        'produk_id',
        'qty',
        'harga_jual',
        'sub_total',
    ];
    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'transaksi_id');
    }
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }
}