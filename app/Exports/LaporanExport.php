<?php

namespace App\Exports;

use App\Models\Barang;
use App\Models\Supplier;
use App\Models\Konsumen;
use App\Models\Pemesanan;
use App\Models\Pembelian;
use App\Models\Penjualan;
use App\Models\ReturPembelian;
use App\Models\ReturPenjualan;
use App\Models\Penagihan;
use App\Models\PembayaranHutang;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class LaporanExport implements FromCollection, WithHeadings, WithTitle
{
    protected $jenis;

    public function __construct($jenis)
    {
        $this->jenis = $jenis;
    }

    public function collection()
    {
        return match ($this->jenis) {
            'barang'          => Barang::all(),
            'supplier'        => Supplier::all(),
            'konsumen'        => Konsumen::all(),
            'pemesanan'       => Pemesanan::all(),
            'pembelian'       => Pembelian::all(),
            'penjualan'       => Penjualan::all(),
            'retur-pembelian' => ReturPembelian::all(),
            'retur-penjualan' => ReturPenjualan::all(),
            'penagihan'       => Penagihan::all(),
            'hutang'          => PembayaranHutang::all(),
            default           => collect(),
        };
    }

    public function headings(): array
    {
        $data = $this->collection();

        if ($data->isEmpty()) {
            return [];
        }

        return array_keys($data->first()->getAttributes());
    }

    public function title(): string
    {
        return 'Laporan ' . ucfirst($this->jenis);
    }
}