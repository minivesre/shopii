<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Pembelian;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    // Menampilkan daftar produk
    public function index()
    {
        // Mengambil semua data produk
        $produks = Produk::all();

        // Mengirim data ke tampilan
        return view('adminHome', ['produks' => $produks]);
    }

    // Menampilkan form tambah produk
    public function create()
    {
        return view('produk.create');
    }

    // Menyimpan data produk baru
    public function store(Request $request)
    {
        $request->validate([
            'kode_produk' => 'required|unique:produks',
            'nama' => 'required',
            'harga' => 'required',
        ]);

        // Membuat produk baru
        Produk::create($request->all());

        // Redirect ke halaman /admin/home dengan pesan sukses
        return redirect('/admin/home')
            ->with('success', 'Produk berhasil ditambahkan');
    }

    // Menampilkan form untuk mengedit produk
    public function edit($id)
    {
        // Mencari produk berdasarkan ID
        $produk = Produk::find($id);

        // Mengirim data produk ke tampilan edit
        return view('produk.edit', compact('produk'));
    }

    // Memperbarui data produk
    public function update(Request $request, $id)
    {
        $request->validate([
            'kode_produk' => 'required',
            'nama' => 'required',
            'harga' => 'required',
        ]);

        // Mencari produk berdasarkan ID
        $produk = Produk::find($id);

        // Memperbarui data produk
        $produk->update($request->all());

        // Redirect ke halaman /admin/home dengan pesan sukses
        return redirect('/admin/home')
            ->with('success', 'Produk berhasil diperbarui');
    }

    // Menghapus produk
    public function destroy($id)
    {
        // Mencari produk berdasarkan ID
        $produk = Produk::find($id);

        // Menghapus produk
        $produk->delete();

        // Redirect ke halaman /admin/home dengan pesan sukses
        return redirect('/admin/home')
            ->with('success', 'Produk berhasil dihapus');
    }
}
