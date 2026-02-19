<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProdukTemplateExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return collect([]);
    }

    public function headings(): array
    {
        return [
            'nama_produk',
            'kategori_id',
            'supplier_id',
            'variasi',
            'deskripsi',
            'ukuran',
            'harga_modal',
            'harga_jual',
            'stok'
        ];
    }
}
