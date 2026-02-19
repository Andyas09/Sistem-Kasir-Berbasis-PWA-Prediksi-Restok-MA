<?php

namespace App\Imports;

use App\Models\Produk;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProdukImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Produk([
            'nama_produk' => $row['nama_produk'],
            'kategori_id' => $row['kategori_id'],
            'supplier_id' => $row['supplier_id'],
            'warna' => $row['variasi'] ?? $row['warna'],
            'deskripsi' => $row['deskripsi'],
            'ukuran' => $row['ukuran'],
            'harga_modal' => $row['harga_modal'],
            'harga_jual' => $row['harga_jual'],
            'stok' => $row['stok'],
        ]);
    }
}
