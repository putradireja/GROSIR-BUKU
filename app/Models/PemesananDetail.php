<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PemesananDetail extends Model
{
    use HasFactory;

    protected $fillable = ['pemesanan_id', 'barang_id', 'qty', 'harga_satuan'];

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    public function pemesanan()
    {
        return $this->belongsTo(Pemesanan::class);
    }
}