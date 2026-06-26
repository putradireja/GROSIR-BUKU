<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penagihan extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_tagih', 
        'tgl_tagih', 
        'penjualan_id', 
        'konsumen_id', 
        'total_piutang', 
        'jumlah_bayar', 
        'sisa_piutang', 
        'ket'
    ];

    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class);
    }

    public function konsumen()
    {
        return $this->belongsTo(Konsumen::class);
    }
}