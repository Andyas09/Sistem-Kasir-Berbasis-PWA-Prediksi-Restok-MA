<?php

namespace App\Exports;

use App\Models\Produk;
use App\Models\StokKeluar;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Carbon\Carbon;

class PrediksiExport implements FromCollection, WithHeadings
{
    protected $produk_id;
    protected $periode;

    public function __construct($produk_id, $periode)
    {
        $this->produk_id = $produk_id;
        $this->periode = $periode;
    }

    public function collection()
    {
        $produk = Produk::find($this->produk_id);
        $startDate = Carbon::now()->subDays($this->periode);

        $histori = StokKeluar::where('produk_id', $this->produk_id)
            ->where('alasan', 'penjualan')
            ->whereDate('created_at', '>=', $startDate)
            ->orderBy('created_at')
            ->get();

        $totalTerjual = $histori->sum('jumlah');
        $rataRata = $this->periode > 0 ? round($totalTerjual / $this->periode, 2) : 0;
        $safetyStock = round($rataRata * 0.2 * $this->periode);
        $stokSekarang = $produk->stok ?? 0;
        $estimasiHabis = $rataRata > 0 ? round($stokSekarang / $rataRata, 1) : 0;
        $rekomendasi = round(($rataRata * $this->periode) + $safetyStock - $stokSekarang);
        if ($rekomendasi < 0) $rekomendasi = 0;

        return collect([[
            'Produk' => $produk->nama_produk,
            'Stok Saat Ini' => $stokSekarang,
            'Rata-rata Penjualan' => $rataRata,
            'Safety Stock' => $safetyStock,
            'Estimasi Habis (Hari)' => $estimasiHabis,
            'Rekomendasi Restok' => $rekomendasi,
        ]]);
    }

    public function headings(): array
    {
        return [
            'Produk',
            'Stok Saat Ini',
            'Rata-rata Penjualan',
            'Safety Stock',
            'Estimasi Habis (Hari)',
            'Rekomendasi Restok'
        ];
    }
}
