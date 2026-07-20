<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanExport;
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

class LaporanController extends Controller
{
    public function index()
    {
        return view('laporan.index');
    }

    public function cetak(Request $request)
    {
        $jenis = $request->input('jenis');
        $data = $this->getData($jenis);

        return view('laporan.cetak', compact('jenis', 'data'));
    }

    public function exportPdf($jenis)
    {
        $data = $this->getData($jenis);

        $pdf = Pdf::loadView('laporan.pdf', compact('jenis', 'data'))
            ->setPaper('a4', 'portrait');

        return $pdf->download("laporan_{$jenis}.pdf");
    }

    public function exportExcel($jenis)
    {
        return Excel::download(new LaporanExport($jenis), "laporan_{$jenis}.xlsx");
    }

    private function getData($jenis)
    {
        return match ($jenis) {
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
            default           => abort(404, 'Jenis laporan tidak ditemukan'),
        };
    }
}