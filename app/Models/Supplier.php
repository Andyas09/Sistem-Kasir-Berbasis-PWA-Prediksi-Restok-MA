<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Kategori;

class Supplier extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $table = 'supplier';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nama_supplier',
        'alamat',
        'telepon',
    ];
}