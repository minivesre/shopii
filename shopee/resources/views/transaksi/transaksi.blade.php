@extends('layouts.app') 

@section('content') 
<div class="container"> 
    <div class="row justify-content-center"> 
        <div class="col-md-8"> 
            <div class="card"> 
                <div class="card-header d-flex justify-content-between"> 
                    <div>{{ __('Data Produk') }}</div> 
                    <div><a href="{{ route('home') }}" style="text-decoration: none;">{{ __('Beranda') }}</a></div> 
                    <div><a href="{{ route('transaksi.cart') }}" style="text-decoration: none;">{{ __('Cart Tiket') }}</a></div> 
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
                                <th class="text-center">Aksi</th> 
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
                                        <form action="{{ route('transaksi.clear', $transaksi->id) }}" method="POST"> 
                                            @csrf 
                                            @method('POST') 
                                            <!-- Cek status transaksi --> 
                                            @if($transaksi->status == 'Pending') 
                                                <button type="submit" class="btn btn-sm btn-danger me-0">Batal</button> 
                                            @elseif($transaksi->status == 'Selesai') 
                                                <a href="{{ route('transaksi.cetak', $transaksi->id) }}" target="_blank" 
                                                   class="btn btn-sm btn-success me-0">Cetak</a> 
                                            @endif 
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
