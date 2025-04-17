<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    public function index()
    {
        $produks = Produk::all();
        return view('produk.index', compact('produks'));
    }

    public function create()
    {
        return view('produk.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'produk' => 'required|string|max:255',
            'harga' => 'required|integer',
            'stok' => 'required|integer|min:0',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('produk', 'public');
        }

        Produk::create($data);

        return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(Produk $produk)
    {
        return view('produk.edit', compact('produk'));
    }

    public function update(Request $request, Produk $produk)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'produk' => 'required|string|max:255',
            'harga' => 'required|integer',
            'stok' => 'required|integer|min:0',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            if ($produk->image) {
                Storage::disk('public')->delete($produk->image);
            }
            $data['image'] = $request->file('image')->store('produk', 'public');
        }

        $produk->update($data);

        return redirect()->route('produk.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Produk $produk)
    {
        $penjualanTerkait = $produk->detailPenjualans()->exists();

        if ($penjualanTerkait) {
            return redirect()->route('produk.index')->with('error', 'Produk tidak dapat dihapus karena sudah pernah dijual.');
        }
    
        if ($produk->image) {
            Storage::disk('public')->delete($produk->image);
        }
    
        $produk->delete();
    
        return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus.');
    }

    public function updateStok(Request $request, $id)
    {
        $request->validate([
            'stok' => 'required|integer|min:0'
        ]);

        $produk = Produk::findOrFail($id);
        $produk->stok = $request->stok;
        $produk->save();

        return redirect()->route('produk.index')->with('success', 'Stok produk berhasil diperbarui.');
    }
}
