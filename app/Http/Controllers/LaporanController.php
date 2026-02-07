<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi_detail;
use App\Models\StokKeluar;
use App\Models\StokMasuk;

class LaporanController extends Controller
{
    private function setActive($page)
    {
        return [
            'activeLaporan' => $page,
            'laporanActive' => true,
        ];
    }
    public function index(Request $request)
    {
        $dari = $request->dari;
        $sampai = $request->sampai;
        $jenis = $request->jenis;

        $laporan = collect();
        $ringkasan = [
            'total_transaksi' => 0,
            'total_omzet' => 0,
            'barang_masuk' => 0,
            'barang_keluar' => 0,
        ];
        if ($jenis == 'penjualan' || !$jenis) {

            $penjualan = Transaksi_detail::with('produk', 'transaksi')
                ->when($dari && $sampai, function ($q) use ($dari, $sampai) {
                    $q->whereHas('transaksi', function ($t) use ($dari, $sampai) {
                        $t->whereBetween('updated_at', [$dari, $sampai]);
                    });
                })->get();

            foreach ($penjualan as $p) {
                $laporan->push([
                    'tanggal' => $p->transaksi->updated_at,
                    'keterangan' => 'Penjualan',
                    'produk' => $p->produk->nama_produk,
                    'qty' => $p->qty,
                    'total' => $p->sub_total,
                ]);
            }
            $ringkasan['total_transaksi'] += $penjualan
                ->pluck('transaksi_id')
                ->unique()
                ->count();
            $ringkasan['total_omzet'] += $penjualan->sum('sub_total');
        }
        if ($jenis == 'stok_masuk' || !$jenis) {

            $masuk = StokMasuk::with('produk')
                ->when(
                    $dari && $sampai,
                    fn($q) =>
                    $q->whereBetween('updated_at', [$dari, $sampai])
                )->get();

            foreach ($masuk as $m) {
                $laporan->push([
                    'tanggal' => $m->updated_at,
                    'keterangan' => 'Stok Masuk',
                    'produk' => $m->produk->nama_produk,
                    'qty' => $m->jumlah,
                    'total' => $m->total,
                ]);
            }

            $ringkasan['barang_masuk'] += $masuk->sum('jumlah');
        }
        if ($jenis == 'stok_keluar' || !$jenis) {

            $keluar = StokKeluar::with('produk')
                ->when(
                    $dari && $sampai,
                    fn($q) =>
                    $q->whereBetween('updated_at', [$dari, $sampai])
                )->get();

            foreach ($keluar as $k) {
                $laporan->push([
                    'tanggal' => $k->updated_at,
                    'keterangan' => 'Stok Keluar',
                    'produk' => $k->produk->nama_produk,
                    'qty' => $k->jumlah,
                    'total' => $k->total,
                ]);
            }
            $ringkasan['barang_keluar'] += $keluar->sum('jumlah');
        }
        $laporan = $laporan->sortByDesc('tanggal')->values();

        return view(
            'laporan.index',
            compact('laporan', 'ringkasan', 'dari', 'sampai', 'jenis'),
            $this->setActive('laporan')
        );
    }

}
