@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>
                <div>
                    <a href="{{ route('produk.create') }}" class="btn btn-sm btn-primary">Tambah Produk</a>
                </div>
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
                                <td>{{ $produk->harga }}</td>
                                <td>
                                    <a href="{{ route('produk.edit', $produk->id) }}" class="btn btn-warning">Edit</a>
                                    <form action="{{ route('produk.destroy', $produk->id) }}" method="POST" style="display:inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">Hapus</button>
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
    </div>
</div>
@endsection
