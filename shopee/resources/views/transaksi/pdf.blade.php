<!DOCTYPE html> 
<html lang="en"> 
<head> 
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>Transaksi PDF</title> 
</head> 
<body> 
    <h1>Detail Transaksi</h1> 
    <p>Kode Produk: {{ $transaksi->kode_produk }}</p> 
    <p>Nama Pembeli: {{ $transaksi->nama_user }}</p> 
    <p>Status: {{ $transaksi->status }}</p> 
    <p>Tanggal Transaksi: {{ $transaksi->created_at }}</p> 
</body> 
</html>