<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
   public function produk()
   {
     return $this->belongsTo('Produk::class');
   }

   public function cart()
   {
     return $this->belongsTo(Cart::class);
   }
// use HasFactory;
protected $fillable = ['kode_produk', 'nama', 'harga'];
}