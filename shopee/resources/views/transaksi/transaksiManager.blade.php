@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">

                <div class="card-header d-flex justify-content-between">
                    <div>{{ __('Data Produk') }}</div>
                    <div>
                        <a href="{{ route('adminHome') }}" style="text-decoration: none;">
                            {{ __('Beranda') }}
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <table class="table">
                        <thead>
                            <tr>
                                <th>Kode Produk</th>
                                <th>Nama Pembeli</th>
                                <th>Harga</th>
                                <th>Status</th>
                                <th>Tanggal Transaksi</th>
                                <th class="text-center" colspan="2">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transaksis as $transaksi)
                                <tr>
                                    <td>{{ $transaksi->kode_produk }}</td>
                                    <td>{{ $transaksi->nama_user }}</td>
                                    <td>{{ $transaksi->harga }}</td>
                                    <td style="color: {{ $transaksi->status == 'Selesai' ? 'green' : ($transaksi->status == 'Pending' ? 'red' : 'black') }};">
                                        {{ $transaksi->status }}
                                    </td>
                                    <td>{{ $transaksi->created_at }}</td>
                                    <td>
                                        <form action="{{ route('transaksi.hapus', $transaksi->id) }}" method="POST">
                                            @csrf
                                            @method('POST')
                                            <button type="submit" class="btn btn-sm btn-danger">Batal</button>
                                        </form>
                                    </td>
                                    <td>
                                        <form action="{{ route('transaksi.konfirmasi', $transaksi->id) }}" method="POST">
                                            @csrf
                                            @method('POST')
                                            <button type="submit" class="btn btn-sm btn-success">Konfirmasi</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
