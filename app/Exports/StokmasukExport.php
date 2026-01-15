<?php

namespace App\Exports;

use App\Models\StokMasuk;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class StokmasukExport implements FromCollection, WithHeadings, WithMapping
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $query = StokMasuk::with(['user', 'produk', 'supplier']);

        if ($this->request->filled('tanggal')) {
            $query->whereDate('created_at', $this->request->tanggal);
        }

        if ($this->request->filled('bulan')) {
            $query->whereMonth('created_at', $this->request->bulan);
        }

        if ($this->request->filled('tahun')) {
            $query->whereYear('created_at', $this->request->tahun);
        }

        return $query->orderBy('created_at', 'desc')->get();
    }

    public function headings(): array
    {
        return [
            'SKU',
            'Tanggal',
            'Waktu',
            'Penerima',
            'Produk',
            'Variasi',
            'Ukuran',
            'Jumlah',
            'Satuan',
            'Saldo Stok',
            'Catatan',
            'Supplier'
        ];
    }

    public function map($sm): array
    {
        return [
            $sm->sku ?? '-',
            $sm->created_at->format('d/m/Y'),
            $sm->created_at->format('H:i'),
            $sm->user->nama ?? '-',
            $sm->produk->nama_produk ?? '-',
            $sm->produk->warna ?? '-',
            $sm->produk->ukuran ?? '-',
            $sm->jumlah,
            $sm->satuan,
            $sm->produk->stok ?? 0,
            $sm->catatan,
            $sm->supplier->nama_supplier ?? '-',
        ];
    }

}
