<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_beli', 'tgl_beli', 'pemesanan_id', 'tipe', 
        'supplier_id', 'jatuh_tempo', 'status_bayar', 'total'
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function pemesanan()
    {
        return $this->belongsTo(Pemesanan::class);
    }

    public function details()
    {
        return $this->hasMany(PembelianDetail::class);
    }
}