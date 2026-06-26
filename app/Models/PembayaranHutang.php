<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembayaranHutang extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_bayar', 
        'tgl_bayar', 
        'pembelian_id', 
        'supplier_id', 
        'total_hutang', 
        'jumlah_bayar', 
        'sisa_hutang', 
        'ket'
    ];

    public function pembelian()
    {
        return $this->belongsTo(Pembelian::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}