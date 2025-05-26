<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\User;
use App\Models\Cart;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Auth;
use PDF;

class PembelianController extends Controller
{
    /**
     * Menampilkan halaman transaksi dengan semua tiket, pengguna, dan cart.
     */
    public function index()
{
    $produks = Produk::all();
    $users = User::all();
    $carts = Cart::all();
    $transaksis = Transaksi::all(); // tambahkan ini jika dibutuhkan oleh view

    return view('transaksi.transaksi', compact('produks', 'users', 'carts', 'transaksis'));
}


    /**
     * Menampilkan halaman cart milik user yang sedang login.
     */
    public function transaksiCart()
    {
        $user = Auth::user();
        $carts = Cart::where('user_id', $user->id)->get();

        return view('transaksi.cart', compact('carts'));
    }

    /**
     * Menambahkan tiket ke dalam cart (membeli tiket).
     */
    public function beli(Request $request)
    {
        $request->validate([
            'produk_id' => 'required|exists:produks,id',
        ]);        

        $user = Auth::user();
        $produk = Produk::findOrFail($request->produk_id);

        if (!$produk) {
            return redirect()->back()->with('error', 'Produk tidak ditemukan.');
        }

        $cart = new Cart();
        $cart->user_id = $user->id;
        $cart->kode_produk = $produk->kode_produk;
        $cart->nama_user = $user->name;
        $cart->harga = $produk->harga;
        $cart->status = 'Pending';
        $cart->save();

        return redirect()->route('transaksi.cart')->with('success', 'Produk berhasil dipesan!');
    }

    /**
     * Menghapus item dari cart berdasarkan ID cart milik user login.
     */
    public function clearcart($id)
    {
        $cart = Cart::where('id', $id)->where('user_id', auth()->id())->first();

        if ($cart) {
            $cart->delete();
            return redirect()->route('transaksi.cart')->with('success', 'Item berhasil dihapus dari cart.');
        }

        return redirect()->route('transaksi.cart')->with('error', 'Item tidak ditemukan.');
    }

    // Menampilkan daftar transaksi untuk pengguna
    // Menampilkan daftar transaksi untuk pengguna
    public function transaksiIndex()
    {
        $user = Auth::user();
        $transaksis = Transaksi::where('user_id', $user->id)->get(); // Fetch user-specific transactions
        return view('transaksi.transaksi', compact('transaksis')); // Pass the variable to the view
    }
    
    public function transaksiIndexManager()
    {
        $transaksis = Transaksi::all(); // Fetch all transactions for admin
        return view('transaksi.transaksiManager', compact('transaksis')); // Pass the variable to the view
    }
    

    // Membayar produk dari cart dan membuat transaksi
    public function bayar(Request $request)
    {
        $request->validate([
            'cart_id' => 'required|exists:carts,id'
        ]);

        $user = Auth::user();
        $cart = Cart::findOrFail($request->cart_id);

        $transaksi = new Transaksi();
        $transaksi->user_id = $user->id;
        $transaksi->kode_produk = $cart->kode_produk;
        $transaksi->nama_user = $user->name;
        $transaksi->harga = $cart->harga;
        $transaksi->status = 'Pending';
        $transaksi->save();

        $cart->delete();

        return redirect()->route('transaksi.transaksi')
            ->with('success', 'Produk berhasil dibayar dan masuk ke transaksi!');
    }

    // Menghapus transaksi dari halaman admin
    public function hapus($id)
    {
        $transaksi = Transaksi::find($id);

        if ($transaksi) {
            $transaksi->delete();
            return redirect()->route('transaksi.transaksiManager')
                ->with('success', 'Transaksi berhasil dihapus');
        }

        return redirect()->route('transaksi.transaksiManager')
            ->with('error', 'Transaksi tidak ditemukan.');
    }

    // Menghapus transaksi dari halaman pengguna
    public function clear($id)
    {
        $transaksi = Transaksi::find($id);

        if ($transaksi) {
            $transaksi->delete();
            return redirect()->route('transaksi.transaksi')
                ->with('success', 'Transaksi berhasil dihapus');
        }

        return redirect()->route('transaksi.transaksi')
            ->with('error', 'Transaksi tidak ditemukan');
    }

    // Mengonfirmasi status transaksi menjadi selesai
    public function konfirmasiStatus($id)
    {
        $transaksi = Transaksi::find($id);

        if ($transaksi) {
            $transaksi->status = 'Selesai';
            $transaksi->save();

            return redirect()->route('transaksi.transaksiManager')
                ->with('success', 'Transaksi berhasil dikonfirmasi.');
        }

        return redirect()->route('transaksi.transaksiManager')
            ->with('error', 'Transaksi tidak ditemukan.');
    }

    // Generate PDF dari transaksi
    public function generatePdf($id)
    {
        $transaksi = Transaksi::find($id);

        if (!$transaksi) {
            return redirect()->back()->with('error', 'Transaksi tidak ditemukan.');
        }

        $pdf = PDF::loadView('transaksi.pdf', compact('transaksi'));
        return $pdf->download('transaksi-' . $transaksi->kode_produk . '.pdf');
    }

}
