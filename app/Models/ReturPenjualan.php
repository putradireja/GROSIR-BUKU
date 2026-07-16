<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReturPenjualan extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_retur',
        'tgl_retur',
        'penjualan_id',
        'konsumen_id',   // ✅ ditambahkan, ini yang tadinya hilang
        'supplier_id',   // tetap dipertahankan (nullable, sesuai controller)
        'alasan',
        'total_retur',   // ✅ ditambahkan, dipakai di controller store()
    ];

    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class);
    }

    public function konsumen()
    {
        return $this->belongsTo(Konsumen::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function details()
    {
        return $this->hasMany(ReturPenjualanDetail::class);
    }
}