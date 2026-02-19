<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Kategori;
use App\Models\Transaksi;
use App\Models\Transaksi_detail;
use App\Models\StokKeluar;
use App\Models\StokMasuk;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Exports\TransaksiExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
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
    public function exportPdf()
    {
        $data = Transaksi::orderBy('created_at', 'desc')->with('user', 'details')->get();
        $pdf = PDF::loadView('pos.pos_pdf', compact('data'));
        return $pdf->stream('laporan-transaksi.pdf');
    }

    public function retur()
    {
        return view('pos.retur', $this->setActive('pos-retur'));
    }

    public function returCheck(Request $request)
    {
        $details = Transaksi_detail::with('produk')
            ->where('no_invoice', $request->invoice)
            ->get();

        if ($details->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'Invoice tidak ditemukan']);
        }

        return response()->json([
            'success' => true,
            'data' => $details->map(function ($d) {
                return [
                    'id' => $d->produk_id,
                    'nama_produk' => $d->produk->nama_produk,
                    'qty' => $d->qty,
                    'ukuran' => $d->produk->ukuran,
                    'harga' => $d->harga_jual,
                    'detail_id' => $d->id
                ];
            })
        ]);
    }

    public function returProses(Request $request)
    {
        $request->validate([
            'invoice' => 'required',
            'produk_id' => 'required',
            'qty' => 'required|numeric|min:1',
            'alasan' => 'required'
        ]);

        $detail = Transaksi_detail::where('no_invoice', $request->invoice)
            ->where('produk_id', $request->produk_id)
            ->first();

        if (!$detail) {
            return back()->with('error', 'Item tidak ditemukan dalam invoice tersebut');
        }

        if ($request->qty > $detail->qty) {
            return back()->with('error', 'Jumlah retur melebihi jumlah pembelian');
        }

        DB::transaction(function () use ($request, $detail) {
            // Update Stok
            Produk::where('id', $request->produk_id)->increment('stok', $request->qty);

            // Catat di Stok Masuk
            StokMasuk::create([
                'jumlah' => $request->qty,
                'produk_id' => $request->produk_id,
                'sku' => 'RETUR-' . $request->invoice,
                'catatan' => 'Retur dari invoice ' . $request->invoice . '. Alasan: ' . $request->alasan,
                'user_id' => auth()->id(),
                'total' => 0, // Retur tidak menambah nilai pembelian finansial secara langsung
                'harga_beli' => 0,
                'diskon' => 0
            ]);
        });

        return back()->with('success', 'Retur berhasil diproses. Stok telah diperbarui.');
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

    public function hapusHold($id)
    {
        DB::transaction(function () use ($id) {
            $transaksi = Transaksi::findOrFail($id);
            // Delete details
            $transaksi->details()->delete();
            // Delete transaction
            $transaksi->delete();
        });

        return back()->with('success', 'Transaksi hold berhasil dihapus');
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
        return redirect()->to(url()->previous() . '#keranjang');
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
        return redirect()->to(url()->previous() . '#keranjang');
    }

    public function cartRemove($id)
    {
        $cart = session('cart', []);
        unset($cart[$id]);
        session(['cart' => $cart]);
        return redirect()->to(url()->previous() . '#keranjang');
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
                    'sku' => $invoice,
                    'alasan' => 'Penjualan',
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
    public function bayarHold(Request $request, $id)
    {
        $request->validate([
            'total' => 'required|numeric|min:1',
            'metode' => 'required',
            'bayar' => 'nullable|numeric'
        ]);

        $transaksi = Transaksi::findOrFail($id);

        if ($request->metode === 'Cash' && $request->bayar < $request->total) {
            return back()->with('error', 'Uang pembayaran kurang');
        }

        $cetakStruk = $request->has('cetak_struk') ? 'Ya' : 'Tidak';

        DB::transaction(function () use ($request, $transaksi, $cetakStruk) {
            $transaksi->update([
                'bayar' => $request->bayar ?? $request->total,
                'kembalian' => $request->metode === 'Cash'
                    ? $request->bayar - $request->total
                    : 0,
                'metode' => $request->metode,
                'status' => 'Selesai',
            ]);

            foreach ($transaksi->details as $detail) {
                // Update detail status and struk flag
                $detail->update([
                    'status' => 'Berhasil',
                    'struk' => $cetakStruk,
                ]);

                // Decrement stock
                Produk::where('id', $detail->produk_id)
                    ->decrement('stok', $detail->qty);

                // Record stock out
                StokKeluar::create([
                    'produk_id' => $detail->produk_id,
                    'jumlah' => $detail->qty,
                    'sku' => 'LANJ' . $detail->no_invoice,
                    'alasan' => 'Penjualan',
                    'user_id' => auth()->id()
                ]);
            }
        });

        return $cetakStruk === 'Ya'
            ? redirect()->route('pos.struk', $transaksi->id)
            : redirect()->route('pos.hold')
                ->with('success', 'Pembayaran hold berhasil');
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

