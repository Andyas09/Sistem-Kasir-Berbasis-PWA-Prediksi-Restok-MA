<?php

namespace App\Exports;

use App\Models\StokKeluar;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class StokkeluarExport implements FromCollection, WithHeadings, WithMapping
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $query = StokKeluar::with(['user', 'produk', 'supplier']);

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
            'Penanggung Jawab',
            'Produk',
            'Variasi',
            'Ukuran',
            'Jumlah',
            'Satuan',
            'Saldo Stok',
            'Alasan',
            'Penerima/Supplier'
        ];
    }

    public function map($sk): array
    {
        return [
            $sk->sku ?? '-',
            $sk->created_at->format('d/m/Y'),
            $sk->created_at->format('H:i'),
            $sk->user->nama ?? '-',
            $sk->produk->nama_produk ?? '-',
            $sk->produk->warna ?? '-',
            $sk->produk->ukuran ?? '-',
            $sk->jumlah,
            $sk->satuan,
            $sk->produk->stok ?? 0,
            $sk->alasan,
            $sk->supplier->nama_supplier ?? '-',
        ];
    }

}
