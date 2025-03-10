<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Produk;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(): View
    {
        $produks = Produk::all();
        // Mengirim data ke tampilan
        return view('home', ['produks' => $produks]);
    }

    public function adminHome(): View
    {
        $produks = Produk::all();
        // Mengirim data ke tampilan
        return view('adminHome', ['produks' => $produks]);
    }
}
