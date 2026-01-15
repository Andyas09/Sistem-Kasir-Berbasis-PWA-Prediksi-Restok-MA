<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'nama' => 'Admin HNSM',
            'username' => 'admin',
            'email' => 'admin@hnsmstore.com',
            'password' => Hash::make('password123'),
            'role_id' => 1,
            'status' => 'Aktif'
        ]);
    }
}

