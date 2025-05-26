@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                
                <!-- Header -->
                <div class="card-header d-flex justify-content-between">
                    <div>{{ __('Data Tiket') }}</div>
                    <div>
                        <a href="{{ route('home') }}" style="text-decoration: none;">
                            {{ __('Beranda') }}
                        </a>
                    </div>
                    <div>
                        <a href="{{ route('transaksi.transaksi') }}" style="text-decoration: none;">
                            {{ __('Bayar Tiket') }}
                        </a>
                    </div>
                </div>

                <!-- Body -->
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
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($carts as $cart)
                                <tr>
                                    <td>{{ $cart->kode_produk }}</td>
                                    <td>{{ $cart->nama_user }}</td>
                                    <td>{{ $cart->harga }}</td>
                                    <td style="color: {{ $cart->status == 'Selesai' ? 'green' : ($cart->status == 'Pending' ? 'red' : 'black') }};">
                                        {{ $cart->status }}
                                    </td>
                                    <td>{{ $cart->created_at }}</td>
                                    
                                    <!-- Aksi Beranda -->
                                    <td>
                                        <a href="{{ route('home') }}" class="btn btn-sm btn-primary">Beranda</a>
                                    </td>

                                    <!-- Aksi Bayar -->
                                    <td>
                                        <form action="{{ route('transaksi.bayar') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="cart_id" value="{{ $cart->id }}">
                                            <button type="submit" class="btn btn-sm btn-success">Bayar</button>
                                        </form>
                                    </td>

                                    <!-- Aksi Batal -->
                                    <td>
                                        @if($cart->status == 'Pending')
                                            <form action="{{ route('transaksi.clearcart', $cart->id) }}" method="POST">
                                                @csrf
                                                @method('POST')
                                                <button type="submit" class="btn btn-sm btn-danger">Batal</button>
                                            </form>
                                        @elseif($cart->status == 'Selesai')
                                            <a href="{{ route('transaksi.cetak', $cart->id) }}" target="_blank" class="btn btn-sm btn-success">Cetak</a>
                                        @endif
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
