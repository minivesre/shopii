<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Transaksi extends Model
{
   public function produk()
   {
     return $this->belongsTo('Produk::class');
   }
   public function transaksi()
   {
     return $this->belongsTo(Transaksi::class);
   }
// use HasFactory;
protected $fillable = ['kode_produk', 'nama', 'harga',];
}