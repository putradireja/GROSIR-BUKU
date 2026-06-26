<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturPembelian extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_retur', 
        'tgl_retur', 
        'pembelian_id', 
        'supplier_id', 
        'keterangan'
    ];

    public function pembelian()
    {
        return $this->belongsTo(Pembelian::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function details()
    {
        return $this->hasMany(ReturPembelianDetail::class);
    }
}