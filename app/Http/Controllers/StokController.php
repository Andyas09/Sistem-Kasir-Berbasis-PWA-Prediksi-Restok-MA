<?php

namespace App\Http\Controllers;

use App\Exports\StokkeluarExport;
use App\Exports\StokmasukExport;
use App\Exports\SoTemplateExport;
use Illuminate\Http\Request;
use App\Models\StokMasuk;
use App\Models\StokKeluar;
use App\Models\Produk;
use App\Models\Supplier;
use App\Models\Opname;
use App\Models\OpnameDetail;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Exports\PrediksiExport;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;
class StokController extends Controller
{
    private function setActive($page)
    {
        return [
            'activePage' => $page,
            'stokActive' => true, // submenu stok aktif
        ];
    }

    public function masuk(Request $request)
    {
        $query = StokMasuk::with('produk', 'user');

        if ($request->filled('keyword')) {
            $keyword = $request->keyword;

            $query->where(function ($q) use ($keyword) {
                $q->where('sku', 'like', "%{$keyword}%")
                    ->orWhereHas('produk', function ($qp) use ($keyword) {
                        $qp->where('nama_produk', 'like', "%{$keyword}%");
                    })
                    ->orWhereHas('supplier', function ($qs) use ($keyword) {
                        $qs->where('nama_supplier', 'like', "%{$keyword}%");
                    });
            });
        }
        if ($request->filled('tanggal')) {
            $query->whereDate('created_at', $request->tanggal);
        }
        if ($request->filled('supplier')) {
            $query->where('supplier_id', $request->supplier);
        }

        $stok_masuk = $query->paginate(10)->withQueryString();
        $produk = Produk::select('id', 'stok', 'nama_produk', 'warna', 'ukuran')
            ->distinct()
            ->get();
        $supplier = Supplier::all();
        return view('stok.masuk', compact('stok_masuk', 'produk', 'supplier'), $this->setActive('stok-masuk'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'produk_id' => 'required',
            'supplier_id' => 'required',
            'jumlah' => 'required|numeric|min:1',
            'catatan' => 'required',
            'harga_beli' => 'required|numeric|min:0',
            'diskon' => 'nullable|numeric|min:0',
            'total' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($request) {
            $total = ($request->jumlah * $request->harga_beli) - ($request->diskon ?? 0);
            StokMasuk::create([
                'produk_id' => $request->produk_id,
                'supplier_id' => $request->supplier_id,
                'jumlah' => $request->jumlah,
                'sku' => 'SKU-' . now()->format('dmY') . '-' . str_pad($request->produk_id, 4, '0', STR_PAD_LEFT),
                'harga_beli' => $request->harga_beli,
                'diskon' => $request->diskon ?? 0,
                'total' => $total,
                'catatan' => $request->catatan,
                'user_id' => auth()->id()
            ]);
            Produk::where('id', $request->produk_id)
                ->increment('stok', $request->jumlah);
        });

        return redirect()->back()->with('success', 'Stok masuk berhasil disimpan');
    }
    public function store_keluar(Request $request)
    {
        $request->validate([
            'produk_id' => 'required',
            'jumlah' => 'required|numeric|min:1',
            'satuan' => 'required',
            'alasan' => 'required',
            'supplier_id' => 'nullable|required_if:alasan,Rusak'
        ]);

        DB::transaction(function () use ($request) {

            StokKeluar::create([
                'produk_id' => $request->produk_id,
                'supplier_id' => $request->alasan === 'Rusak'
                    ? $request->supplier_id
                    : null,
                'jumlah' => $request->jumlah,
                'satuan' => $request->satuan,
                'sku' => 'SKU-' . now()->format('dmY') . '-' . str_pad($request->produk_id, 4, '0', STR_PAD_LEFT),
                'alasan' => $request->alasan,
                'user_id' => auth()->id(),
            ]);

            Produk::where('id', $request->produk_id)
                ->decrement('stok', $request->jumlah);
        });
        return redirect()->back()->with('success', 'Stok keluar berhasil disimpan');
    }


    public function keluar(Request $request)
    {
        $query = StokKeluar::with('produk', 'user');

        if ($request->filled('keyword')) {
            $keyword = $request->keyword;

            $query->where(function ($q) use ($keyword) {
                $q->where('sku', 'like', "%{$keyword}%")
                    ->orWhereHas('produk', function ($qp) use ($keyword) {
                        $qp->where('nama_produk', 'like', "%{$keyword}%");
                    })
                    ->orWhereHas('supplier', function ($qs) use ($keyword) {
                        $qs->where('nama_supplier', 'like', "%{$keyword}%");
                    });
            });
        }

        if ($request->filled('tanggal')) {
            $query->whereDate('created_at', $request->tanggal);
        }

        if ($request->filled('alasan')) {
            $query->where('alasan', $request->alasan);
        }


        $stok_keluar = $query->paginate(10)->withQueryString();
        $produk = Produk::select('id', 'stok', 'nama_produk', 'warna', 'ukuran')
            ->distinct()
            ->get();
        $supplier = Supplier::all();
        return view('stok.keluar', compact('produk', 'supplier', 'stok_keluar'), $this->setActive('stok-keluar'));
    }
    public function exportExcelK(Request $request)
    {
        $namaFile = 'stok-keluar_' . now()->format('dmY_His') . '.xlsx';

        return Excel::download(
            new StokkeluarExport($request),
            $namaFile
        );
    }
    public function exportExcelM(Request $request)
    {
        $namaFile = 'stok-masuk_' . now()->format('dmY_His') . '.xlsx';

        return Excel::download(
            new StokmasukExport($request),
            $namaFile
        );
    }

    public function penyesuaian()
    {
        return view('stok.penyesuaian', $this->setActive('stok-penyesuaian'));
    }

    public function opname()
    {
        $sesi = Opname::with('opname', 'user')
            ->orderBy('created_at', 'desc')
            ->get();
        return view('stok.opname', compact('sesi'), $this->setActive('stok-opname'));
    }
    public function destroy_opname($id)
    {
        $opname = Opname::findOrFail($id);
        $opname->opname()->delete();
        $opname->delete();

        return redirect()->back()->with('success', 'Sesi Stock Opname berhasil dihapus!');
    }

    public function riwayat(Request $request)
    {
        // Ambil stok masuk
        $masuk = StokMasuk::with(['produk', 'user', 'supplier'])
            ->when(
                $request->filled('tanggal'),
                fn($q) =>
                $q->whereDate('created_at', $request->tanggal)
            )
            ->when(
                $request->filled('produk_id'),
                fn($q) =>
                $q->where('produk_id', $request->produk_id)
            )
            ->get()
            ->map(function ($m) {
                return [
                    'tanggal' => $m->created_at,
                    'produk' => $m->produk,
                    'jenis' => 'masuk',
                    'qty' => +$m->jumlah,
                    'stok_akhir' => $m->produk->stok,
                    'stok_awal' => $m->produk->stok - $m->jumlah,
                    'keterangan' => $m->supplier->nama_supplier ?? 'Stok Masuk',
                    'user' => $m->user->nama ?? '-',
                ];
            });

        // Ambil stok keluar
        $keluar = StokKeluar::with(['produk', 'user', 'supplier'])
            ->when(
                $request->filled('tanggal'),
                fn($q) =>
                $q->whereDate('created_at', $request->tanggal)
            )
            ->when(
                $request->filled('produk_id'),
                fn($q) =>
                $q->where('produk_id', $request->produk_id)
            )
            ->get()
            ->map(function ($k) {
                return [
                    'tanggal' => $k->created_at,
                    'produk' => $k->produk,
                    'jenis' => 'keluar',
                    'qty' => -$k->jumlah,
                    'stok_akhir' => $k->produk->stok,
                    'stok_awal' => $k->produk->stok + $k->jumlah,
                    'keterangan' => $k->alasan,
                    'user' => $k->user->nama ?? '-',
                ];
            });

        // Gabungkan & sortir
        $riwayat = $masuk
            ->merge($keluar)
            ->sortByDesc('tanggal');

        $produk = Produk::orderBy('nama_produk')->get();
        return view('stok.riwayat', compact('riwayat', 'produk'), $this->setActive('stok-riwayat'));
    }
    public function exportTemplateSO()
    {
        $data = Produk::select(
            'id',
            'nama_produk',
            'stok as stok_awal'
        )->get()->map(function ($p) {
            return [
                'Kode Produk' => $p->id,
                'Nama Produk' => $p->nama_produk,
                'Stok Awal' => $p->stok_awal,
                'Terjual' => 0,
                'Rusak' => 0,
            ];
        });

        return Excel::download(
            new SoTemplateExport($data),
            'template_stock_opname.xlsx'
        );
    }
    // Simpan Sesi SO
    public function opname_store(Request $request)
    {
        $request->validate([
            'nama_sesi' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'input_type' => 'required|in:manual,excel',
        ]);

        // Simpan header sesi
        $opname = Opname::create([
            'nama_sesi' => $request->nama_sesi,
            'tanggal' => $request->tanggal,
            'input_type' => $request->input_type,
            'user_id' => auth()->id(),
        ]);

        if ($request->input_type === 'manual') {
            $request->validate([
                'produk_id.*' => 'required|exists:produk,id',
                'stok_awal.*' => 'required|numeric|min:0',
                'terjual.*' => 'nullable|numeric|min:0',
                'rusak.*' => 'nullable|numeric|min:0',
            ]);

            foreach ($request->produk_id as $i => $produk_id) {
                $produk = Produk::find($produk_id);

                $stokAkhir = $request->stok_awal[$i] - ($request->terjual[$i] ?? 0) - ($request->rusak[$i] ?? 0);

                // Update stok produk
                $produk->update(['stok' => $stokAkhir]);

                // Simpan detail opname
                OpnameDetail::create([
                    'stok_id' => $opname->id,
                    'produk_id' => $produk_id,
                    'stok_sistem' => $request->stok_awal[$i],
                    'terjual' => $request->terjual[$i] ?? 0,
                    'rusak' => $request->rusak[$i] ?? 0,
                    'stok_fisik' => $stokAkhir,
                ]);
            }

        } elseif ($request->input_type === 'excel') {
            $request->validate([
                'file_excel' => 'required|file|mimes:xlsx,xls',
            ]);

            $file = $request->file('file_excel');
            $spreadsheet = IOFactory::load($file->getPathName());
            $sheet = $spreadsheet->getActiveSheet()->toArray();

            for ($i = 1; $i < count($sheet); $i++) { // mulai dari row 2 (header row 1)
                $row = $sheet[$i];
                $kode_produk = $row[0];
                $stok_awal = $row[2] ?? 0;
                $terjual = $row[3] ?? 0;
                $rusak = $row[4] ?? 0;

                $produk = Produk::where('id', $kode_produk)->first();
                if ($produk) {
                    $stokAkhir = $stok_awal - $terjual - $rusak;

                    // Update stok
                    $produk->update(['stok' => $stokAkhir]);
                    OpnameDetail::create([
                        'stok_id' => $opname->id,
                        'produk_id' => $produk->id,
                        'stok_sistem' => $stok_awal,
                        'terjual' => $terjual,
                        'rusak' => $rusak,
                        'stok_fisik' => $stokAkhir,
                    ]);
                }
            }
        }

        return redirect()->back()->with('success', 'Sesi Stock Opname berhasil disimpan!');
    }
    public function prediksi(Request $request)
    {
        $produk = Produk::all();
        $prediksi = null;

        if ($request->filled('produk_id') && $request->filled('periode')) {
            $produk_id = $request->produk_id;
            $periode = (int) $request->periode;

            $produkModel = Produk::find($produk_id);
            $stokSekarang = $produkModel->stok ?? 0;

            $startDate = Carbon::now()->subDays($periode);
            $histori = StokKeluar::where('produk_id', $produk_id)
                ->where('alasan', 'Penjualan')
                ->whereDate('created_at', '>=', $startDate)
                ->orderBy('created_at')
                ->get();

            $totalTerjual = $histori->sum('jumlah');
            $rataRata = $periode > 0 ? round($totalTerjual / $periode, 2) : 0;

            $safetyStock = round($rataRata * 0.2 * $periode);

            $estimasiHabis = $rataRata > 0 ? round($stokSekarang / $rataRata, 1) : 0;

            $rekomendasi = round(($rataRata * $periode) + $safetyStock - $stokSekarang);
            if ($rekomendasi < 0)
                $rekomendasi = 0;

            $prediksi = [
                'produk' => $produkModel,
                'stok_sekarang' => $stokSekarang,
                'rata_rata' => $rataRata,
                'safety_stock' => $safetyStock,
                'estimasi_habis' => $estimasiHabis,
                'rekomendasi' => $rekomendasi,
                'histori' => $histori,
            ];
        }
        return view('stok.prediksi', compact('produk', 'prediksi'), $this->setActive('stok-prediksi'));
    }
}
