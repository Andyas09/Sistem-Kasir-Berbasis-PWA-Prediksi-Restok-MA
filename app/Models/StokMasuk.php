<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Supplier;
use App\Models\Produk;
use App\Models\User;
use App\Models\Kategori;

class StokMasuk extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $table = 'stok_masuk';
    protected $primaryKey = 'id';
    protected $fillable = [
        'jumlah',
        'supplier_id',
        'produk_id',
        'sku',
        'diskon',
        'satuan',
        'total',
        'harga_beli',
        'catatan',
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
