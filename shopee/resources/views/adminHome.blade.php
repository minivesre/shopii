@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span><strong>Data Produk</strong></span>
                    <a href="{{ route('produk.create') }}" style="text-decoration: none; color: #007bff;">
                        Tambah Data Produk
                    </a>
                    <nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
    <div class="container">
        
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('transaksi.transaksiManager') }}">Transaksi</a>
                </li>
              </div>
</nav>

                </div>

                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Kode Produk</th>
                                <th>Nama</th>
                                <th>Harga</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($produks) && count($produks) > 0)
                                @foreach ($produks as $produk)
                                    <tr>
                                        <td>{{ $produk->kode_produk }}</td>
                                        <td>{{ $produk->nama }}</td>
                                        <td>Rp {{ number_format($produk->harga, 0, ',', '.') }}</td>
                                        <td>
                                            <a href="{{ route('produk.edit', $produk->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                            <form action="{{ route('produk.destroy', $produk->id) }}" method="POST" style="display:inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="4" class="text-center">Tidak ada produk tersedia.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Daftar Transaksi untuk Dikonfirmasi --}}
            <div class="card">
                <div class="card-header">
                    <strong>Transaksi Menunggu Konfirmasi</strong>
                </div>
                <div class="card-body">
                    @if(isset($transaksis) && count($transaksis) > 0)
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID Transaksi</th>
                                    <th>User</th>
                                    <th>Total</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transaksis as $transaksi)
                                    <tr>
                                        <td>{{ $transaksi->id }}</td>
                                        <td>{{ $transaksi->user->name ?? 'Tidak diketahui' }}</td>
                                        <td>Rp {{ number_format($transaksi->total, 0, ',', '.') }}</td>
                                        <td>
                                            <form action="{{ route('transaksi.konfirmasi', ['id' => $transaksi->id]) }}" method="POST" style="display:inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm">Konfirmasi</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="text-muted">Tidak ada transaksi yang menunggu konfirmasi.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection