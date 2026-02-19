<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Kategori;
use App\Models\Supplier;
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
        $query = Produk::with('kategori', 'supplier');

        if ($request->search) {
            $query->where('nama_produk', 'like', '%' . $request->search . '%');
        }

        if ($request->kategori) {
            $query->where('kategori_id', $request->kategori);
        }

        if ($request->ukuran) {
            $query->where('ukuran', $request->ukuran);
        }

        if ($request->stok === 'habis') {
            $query->where('stok', 0);
        }

        if ($request->stok === 'ada') {
            $query->where('stok', '>', 0);
        }
        $produk = $query->orderBy('updated_at', 'desc')->get();

        $ukurans = Produk::select('ukuran')->distinct()->pluck('ukuran');
        $kategoris = Kategori::all();
        $supplier = Supplier::all();

        return view(
            'produk.index',
            compact('produk', 'kategoris', 'ukurans', 'supplier'),
            $this->setActive('produk')
        );
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
            'supplier_id' => 'required',
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
            'supplier_id' => $request->supplier_id,
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
            'supplier_id' => 'required',
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
            'supplier_id' => $request->supplier_id,
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

        return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus.');
    }

    public function importExcel(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048'
        ]);

        try {
            \Maatwebsite\Excel\Facades\Excel::import(new \App\Imports\ProdukImport, $request->file('file'));
            return back()->with('success', 'Data produk berhasil diimport dari Excel');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengimport data: ' . $e->getMessage());
        }
    }

    public function downloadTemplate()
    {
        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\ProdukTemplateExport, 'template_import_produk.xlsx');
    }
}
