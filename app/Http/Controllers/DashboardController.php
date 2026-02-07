<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\User;


class DashboardController extends Controller
{
    private function setActive($page)
    {
        return [
            'Dashboard' => $page,
            'DashboardActive'  => true,
        ];
    }
    public function index()
    {
        $totalProduk = Produk::count();
        $stokRendah = Produk::where('stok', '<=', 5)->count();
        $totalUser = User::count();
        $produk = Produk::select('nama_produk', 'stok')->get();
        return view('welcome', compact('produk', 'stokRendah', 'totalProduk', 'totalUser'), $this->setActive('dashboard'));
    }
}
