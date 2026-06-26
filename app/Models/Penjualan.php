<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_jual', 'tgl_jual', 'konsumen_id', 'tipe', 
        'jatuh_tempo', 'status_bayar', 'total'
    ];

    public function konsumen()
    {
        return $this->belongsTo(Konsumen::class);
    }

    public function details()
    {
        return $this->hasMany(PenjualanDetail::class);
    }
}