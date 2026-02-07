<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Kategori;
use App\Models\Supplier;
class SupplierController extends Controller
{
    private function setActive($page)
    {
        return [
            'activeSupplier' => $page,
            'supplierActive' => true,
        ];
    }
    public function index(Request $request)
    {
        $query = Supplier::query();

        if ($request->search) {
            $query->where('nama_supplier', 'like', '%' . $request->search . '%');
        }

        $supplier = $query
            ->orderBy('updated_at', 'desc')
            ->get();

        return view(
            'supplier.index',
            compact('supplier'),
            $this->setActive('supplier')
        );
    }



    public function store(Request $request)
    {
        $request->validate([
            'nama_supplier' => 'required',
            'alamat' => 'required',
            'telepon' => 'required',
        ]);

        Supplier::create([
            'nama_supplier' => $request->nama_supplier,
            'alamat' => $request->alamat,
            'telepon' => $request->telepon,
        ]);

        return back()->with('success', 'Supplier berhasil ditambahkan');
    }
    public function update(Request $request, Produk $produk, $id)
    {
        $supplier = Supplier::where('id', $id)->firstOrFail();
        $request->validate([
            'nama_supplier' => 'required',
            'telepon' => 'required',
            'alamat' => 'required',
        ]);
        $supplier->update([
            'nama_supplier' => $request->nama_supplier,
            'alamat' => $request->alamat,
            'telepon' => $request->telepon,
        ]);

        return redirect()->route('supplier.index')->with('success', 'Supplier berhasil diupdate');
    }
    public function destroy($id)
    {
        $supplier = Supplier::where('id', $id)->firstOrFail();
        $supplier->delete();

        return redirect()->route('supplier.index')->with('success', 'Supplier berhasil dihapus.');
    }

}
