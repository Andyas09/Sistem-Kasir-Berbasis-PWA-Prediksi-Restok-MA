<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Produk;
use App\Models\User;
use App\Models\Supplier;

class StokKeluar extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $table = 'stok_keluar';
    protected $primaryKey = 'id';
    protected $fillable = [
        'produk_id',
        'jumlah',
        'alasan',
        'sku',
        'satuan',
        'supplier_id',
        'user_id',
    ];
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }


}
