<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Kategori;
use App\Models\Transaksi;
use App\Models\Transaksi_detail;
use App\Models\StokKeluar;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Exports\TransaksiExport;
use Maatwebsite\Excel\Facades\Excel;
class PosController extends Controller
{
    private function setActive($page)
    {
        return [
            'activePos' => $page,
            'posActive' => true,
        ];
    }

    public function transaksi(Request $request)
    {
        $query = Produk::with('kategori');

        if ($request->filled('search')) {
            $query->where('nama_produk', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('kategori')) {
            $query->where('kategori_id', $request->kategori);
        }

        if ($request->filled('ukuran')) {
            $query->where('ukuran', $request->ukuran);
        }

        if ($request->stok === 'habis') {
            $query->where('stok', 0);
        } elseif ($request->stok === 'ada') {
            $query->where('stok', '>', 0);
        }

        $produk = $query->paginate(10)->withQueryString();
        $kategoris = Kategori::all();
        $ukurans = Produk::select('ukuran')->distinct()->pluck('ukuran');

        // 🔥 AMBIL CART DARI SESSION
        $cart = session('cart', []);

        return view(
            'pos.transaksi',
            compact('produk', 'kategoris', 'ukurans', 'cart'),
            $this->setActive('pos-transaksi')
        );
    }

    public function daftarTransaksi(Request $request)
    {
        $query = Transaksi::with(['user', 'details']);

        // ================= FILTER TANGGAL =================
        if ($request->filled('tanggal')) {
            $query->whereDate('created_at', $request->tanggal);
        }

        // ================= FILTER BULAN =================
        if ($request->filled('bulan')) {
            $query->whereMonth('created_at', $request->bulan);
        }

        // ================= FILTER TAHUN =================
        if ($request->filled('tahun')) {
            $query->whereYear('created_at', $request->tahun);
        }

        // ================= DEFAULT URUT TERBARU =================
        $query->orderBy('created_at', 'desc');

        $transaksis = $query->get();

        return view(
            'pos.daftar',
            compact('transaksis'),
            $this->setActive('pos-daftar')
        );
    }
    public function exportExcel(Request $request)
    {
        $namaFile = 'Daftar-Transaksi' . now()->format('dmY_His') . '.xlsx';

        return Excel::download(
            new TransaksiExport($request),
            $namaFile
        );
    }



    public function retur()
    {
        return view('pos.retur', $this->setActive('pos-retur'));
    }

    public function hold()
    {

        $transaksis = Transaksi::with(['user', 'details'])
            ->where('status', 'Pending')
            ->orderBy('created_at', 'desc')
            ->get();

        return view(
            'pos.hold',
            compact('transaksis'),
            $this->setActive('pos-hold')
        );
    }



    public function riwayat()
    {
        return view('pos.riwayat', $this->setActive('pos-riwayat'));
    }
    public function cartAdd(Request $request)
    {
        $cart = session()->get('cart', []);
        $produk = Produk::findOrFail($request->produk_id);

        if (isset($cart[$produk->id])) {
            $cart[$produk->id]['qty']++;
        } else {
            $cart[$produk->id] = [
                'nama' => $produk->nama_produk,
                'harga' => $produk->harga_jual,
                'qty' => 1
            ];
        }

        session(['cart' => $cart]);
        return back();
    }

    public function cartMinus($id)
    {
        $cart = session('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['qty']--;
            if ($cart[$id]['qty'] <= 0) {
                unset($cart[$id]);
            }
        }

        session(['cart' => $cart]);
        return back();
    }

    public function cartRemove($id)
    {
        $cart = session('cart', []);
        unset($cart[$id]);
        session(['cart' => $cart]);
        return back();
    }
    public function pending(Request $request)
    {
        $cart = session('cart');

        if (!$cart || count($cart) === 0) {
            return redirect()->back()
                ->with('error', 'Keranjang masih kosong');
        }

        DB::transaction(function () use ($cart) {

            $total = 0;

            foreach ($cart as $item) {
                $total += $item['qty'] * $item['harga'];
            }

            $transaksi = Transaksi::create([
                'total' => $total,
                'status' => 'Pending',
                'user_id' => auth()->id()
            ]);
            $invoice = 'INV-' . now()->format('dmY') . '-' . str_pad($transaksi->id, 4, '0', STR_PAD_LEFT);
            foreach ($cart as $produk_id => $item) {
                Transaksi_detail::create([
                    'transaksi_id' => $transaksi->id,
                    'no_invoice' => $invoice,
                    'produk_id' => $produk_id,
                    'qty' => $item['qty'],
                    'harga_jual' => $item['harga'],
                    'sub_total' => $item['qty'] * $item['harga']
                ]);
            }
        });

        // 🔥 HAPUS CART SETELAH HOLD
        session()->forget('cart');

        return redirect()
            ->route('pos.transaksi')
            ->with('success', 'Transaksi berhasil di-hold');
    }
    public function bayar(Request $request)
    {
        $request->validate([
            'total' => 'required|numeric|min:1',
            'metode' => 'required',
            'bayar' => 'nullable|numeric'
        ]);

        if ($request->metode === 'Cash' && $request->bayar < $request->total) {
            return back()->with('error', 'Uang pembayaran kurang');
        }
        $cetakStruk = $request->has('cetak_struk') ? 'Ya' : 'Tidak';

        DB::transaction(function () use ($request, &$transaksi, $cetakStruk) {
            $transaksi = Transaksi::create([
                'total' => $request->total,
                'bayar' => $request->bayar ?? $request->total,
                'kembalian' => $request->metode === 'Cash'
                    ? $request->bayar - $request->total
                    : 0,
                'metode' => $request->metode,
                'status' => 'Selesai',
                'user_id' => auth()->id()
            ]);
            $invoice = 'INV-' . now()->format('dmY') . '-' . str_pad($transaksi->id, 4, '0', STR_PAD_LEFT);
            $cart = session('cart');

            foreach ($cart as $produk_id => $item) {

                Transaksi_detail::create([
                    'transaksi_id' => $transaksi->id,
                    'no_invoice' => $invoice,
                    'produk_id' => $produk_id,
                    'qty' => $item['qty'],
                    'harga_jual' => $item['harga'],
                    'sub_total' => $item['qty'] * $item['harga'],
                    'status' => 'Berhasil',
                    'struk' => $cetakStruk,
                ]);
                Produk::where('id', $produk_id)
                    ->decrement('stok', $item['qty']);
                StokKeluar::create([
                    'produk_id' => $produk_id,
                    'jumlah' => $item['qty'],
                    'sku' => 'jcsbd',
                    'alasan' => 'Penjualan',
                    'satuan' => 'PCS',
                    'user_id' => auth()->id()
                ]);
                
            }

            session()->forget('cart');
        });
        return $cetakStruk === 'Ya'
            ? redirect()->route('pos.struk', $transaksi->id)
            : redirect()->route('pos.transaksi')
                ->with('success', 'Pembayaran berhasil');
    }


    public function struk($id)
    {
        $transaksi = Transaksi::with([
            'user',
            'details.produk'
        ])->findOrFail($id);

        return view('pos.struk', compact('transaksi'));
    }
}

