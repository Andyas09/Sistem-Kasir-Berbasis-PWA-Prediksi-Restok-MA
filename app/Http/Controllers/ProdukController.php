<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Kategori;
class ProdukController extends Controller
{
    private function setActive($page)
    {
        return [
            'activeProduk' => $page,
            'produkActive' => true,
        ];
    }
    public function index(Request $request)
    {
        $query = Produk::with('kategori');

        // 🔍 Filter Nama Produk
        if ($request->search) {
            $query->where('nama_produk', 'like', '%' . $request->search . '%');
        }

        // 🗂 Filter Kategori
        if ($request->kategori) {
            $query->where('kategori_id', $request->kategori);
        }
        //filter ukuran
        if ($request->ukuran) {
            $query->where('ukuran', $request->ukuran);
        }

        // 📦 Filter Stok
        if ($request->stok == 'habis') {
            $query->where('stok', 0);
        }

        if ($request->stok == 'ada') {
            $query->where('stok', '>', 0);
        }

        $produk = $query->paginate(10)->withQueryString();
        $ukurans = Produk::select('ukuran')->distinct()->pluck('ukuran');
        $kategoris = Kategori::all();

        return view('produk.index', compact('produk', 'kategoris', 'ukurans'), $this->setActive('produk'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori_id' => 'required',
            'nama_produk' => 'required',
            'ukuran_pilihan' => 'required',
            'warna' => 'required|string',
            'ukuran_lainnya' => 'nullable|string',
            'harga_modal' => 'required|numeric',
            'harga_jual' => 'required|numeric',
            'stok' => 'required|numeric',
            'deskripsi' => 'required',
            'gambar' => 'nullable|max:2048',
        ]);

        $ukuran = $request->ukuran_pilihan === 'lainnya'
            ? $request->ukuran_lainnya
            : $request->ukuran_pilihan;
        $namaFile = null;
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $namaFile = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('storage'), $namaFile);
        }

        Produk::create([
            'kategori_id' => $request->kategori_id,
            'nama_produk' => $request->nama_produk,
            'warna' => $request->warna,
            'deskripsi' => $request->deskripsi,
            'ukuran' => $ukuran,
            'harga_modal' => $request->harga_modal,
            'harga_jual' => $request->harga_jual,
            'stok' => $request->stok,
            'gambar' => $namaFile,
        ]);

        return back()->with('success', 'Produk berhasil ditambahkan');
    }
    public function update(Request $request, Produk $produk, $id)
    {
        $produk = Produk::where('id', $id)->firstOrFail();
        $request->validate([
            'kategori_id' => 'required',
            'nama_produk' => 'required',
            'ukuran_pilihan' => 'required',
            'warna' => 'required|string',
            'ukuran_lainnya' => 'nullable|string',
            'harga_modal' => 'required|numeric',
            'harga_jual' => 'required|numeric',
            'stok' => 'required|numeric',
            'gambar' => 'nullable|max:2048'
        ]);
        $ukuran = $request->ukuran_pilihan === 'lainnya'
            ? $request->ukuran_lainnya
            : $request->ukuran_pilihan;
        $produk->update([
            'kategori_id' => $request->kategori_id,
            'nama_produk' => $request->nama_produk,
            'warna' => $request->warna, 
            'ukuran' => $ukuran,
            'harga_modal' => $request->harga_modal,
            'harga_jual' => $request->harga_jual,
            'stok' => $request->stok,
        ]);

        if ($request->hasFile('gambar')) {
            if ($produk->gambar && file_exists(public_path('storage/' . $produk->gambar))) {
                unlink(public_path('storage/' . $produk->gambar));
            }
            $file = $request->file('gambar');
            $namaFile = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('storage'), $namaFile);
            $produk->update(['gambar' => $namaFile]);
        }

        return redirect()->route('produk.index')->with('success', 'Produk berhasil diupdate');
    }
    public function destroy($id)
    {
        $produk = Produk::where('id', $id)->firstOrFail();
        if ($produk->gambar && file_exists(public_path('storage/' . $produk->gambar))) {
            unlink(public_path('storage/' . $produk->gambar));
        }
        $produk->delete();

        return redirect()->route('produk.index')->with('pesan_sukses', 'Produk berhasil dihapus.');
    }

}
