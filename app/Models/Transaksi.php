<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\User;
use App\Models\Transaksi_detail;

class Transaksi extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $table = 'transaksi';
    protected $primaryKey = 'id';
    protected $fillable = [
        'tanggal',
        'total',
        'user_id',
        'bayar',
        'kembalian',
        'metode',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function details()
    {
        return $this->hasMany(Transaksi_detail::class, 'transaksi_id');
    }

}