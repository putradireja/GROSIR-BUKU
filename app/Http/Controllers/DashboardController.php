<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Konsumen;
use App\Models\PembayaranHutang;
use App\Models\Pembelian;
use App\Models\Penagihan;
use App\Models\Penjualan;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Ringkasan statistik utama
        $stats = [
            'total_barang'    => Barang::count(),
            'total_supplier'  => Supplier::count(),
            'total_konsumen'  => Konsumen::count(),
            'total_penjualan' => Penjualan::sum('total') ?? 0,
            'total_pembelian' => Pembelian::sum('total') ?? 0,
            'total_piutang'   => Penagihan::sum('sisa_piutang') ?? 0,
            'total_hutang'    => PembayaranHutang::sum('sisa_hutang') ?? 0,
            'stok_menipis'    => Barang::where('stok', '<=', 10)->count(),
        ];

        // Statistik 6 bulan terakhir untuk grafik garis
        $bulanLabels = [];
        $penjualanBulanan = [];
        $pembelianBulanan = [];

        for ($i = 5; $i >= 0; $i--) {
            $bulan = Carbon::now()->subMonths($i);
            $bulanLabels[] = $bulan->translatedFormat('M Y');

            $penjualanBulanan[] = (float) Penjualan::whereYear('tgl_jual', $bulan->year)
                ->whereMonth('tgl_jual', $bulan->month)
                ->sum('total') ?? 0;

            $pembelianBulanan[] = (float) Pembelian::whereYear('tgl_beli', $bulan->year)
                ->whereMonth('tgl_beli', $bulan->month)
                ->sum('total') ?? 0;
        }

        // Distribusi kategori untuk grafik donat
        $kategoriBuku = Barang::selectRaw('kategori, COUNT(*) as jumlah')
            ->groupBy('kategori')
            ->orderByDesc('jumlah')
            ->limit(6)
            ->get();

        $chart = [
            'bulan_labels'      => $bulanLabels,
            'penjualan_bulanan' => $penjualanBulanan,
            'pembelian_bulanan' => $pembelianBulanan,
            'kategori_labels'   => $kategoriBuku->pluck('kategori')->map(fn ($k) => trim((string)$k) ?: 'Lainnya'),
            'kategori_data'     => $kategoriBuku->pluck('jumlah'),
        ];

        return view('dashboard', compact('stats', 'chart'));
    }
}