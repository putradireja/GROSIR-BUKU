<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturPembelianDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'retur_pembelian_id', 
        'barang_id', 
        'qty',
        'harga_satuan', // <--- TAMBAHKAN DI SINI
        'subtotal'      // <--- TAMBAHKAN DI SINI
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    public function returPembelian()
    {
        return $this->belongsTo(ReturPembelian::class);
    }
}