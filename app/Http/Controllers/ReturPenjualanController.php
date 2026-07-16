<?php

namespace App\Http\Controllers;

use App\Models\ReturPenjualan;
use App\Models\ReturPenjualanDetail;
use App\Models\Penjualan;
use App\Models\PenjualanDetail; // ✅ DITAMBAHKAN: Untuk mengambil harga satuan
use App\Models\Barang;
use App\Http\Requests\ReturPenjualanRequest;
use Illuminate\Support\Facades\DB;

class ReturPenjualanController extends Controller
{
    public function index()
    {
        // ✅ PERBAIKAN: Mengganti 'supplier' menjadi 'konsumen'
        $returs = ReturPenjualan::with(['penjualan', 'konsumen'])->latest()->paginate(10);
        return view('retur_penjualan.index', compact('returs'));
    }

    public function create()
    {
        // ✅ PERBAIKAN: Mengganti 'supplier' menjadi 'konsumen'
        $penjualans = Penjualan::with('konsumen')->latest()->get();
        $barangs = Barang::where('stok', '>', 0)->orderBy('judul')->get();
        
        // Generate Nomor Bukti Retur Otomatis
        $date = date('Ymd');
        $last = ReturPenjualan::whereDate('created_at', date('Y-m-d'))->orderBy('id', 'desc')->first();
        
        $nextNumber = $last ? intval(substr($last->no_retur, -3)) + 1 : 1;
        $no_retur = 'RB-' . $date . '-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        return view('retur_penjualan.create', compact('penjualans', 'barangs', 'no_retur'));
    }

    public function store(ReturPenjualanRequest $request)
    {
        DB::beginTransaction();
        try {
            $total_retur = 0;
            $penjualan = Penjualan::findOrFail($request->penjualan_id);

            // 1. Buat Header Retur
            $retur = ReturPenjualan::create([
                'no_retur' => $request->no_retur,
                'tgl_retur' => $request->tgl_retur,
                'penjualan_id' => $request->penjualan_id,
                'konsumen_id' => $penjualan->konsumen_id,
                // ✅ PERBAIKAN: Baris supplier_id DIHAPUS karena ini Retur Penjualan
                'alasan' => $request->keterangan,
                'total_retur' => 0,
            ]);

            // 2. Simpan Detail dan Kurangi Stok Barang
            foreach ($request->barang_id as $key => $barang_id) {
                $qty_retur = $request->qty[$key];
                $barang = Barang::findOrFail($barang_id);

                if ($qty_retur > $barang->stok) {
                    throw new \Exception("Stok {$barang->judul} di gudang tidak mencukupi untuk diretur! Sisa: {$barang->stok}");
                }

                // ✅ PERBAIKAN: Ambil harga satuan dari transaksi penjualan asli
                $penjualanDetail = PenjualanDetail::where('penjualan_id', $request->penjualan_id)
                                    ->where('barang_id', $barang_id)
                                    ->first();

                $harga_satuan = $penjualanDetail ? $penjualanDetail->harga_satuan : ($barang->harga ?? 0);
                
                // ✅ PERBAIKAN: Hitung subtotal
                $subtotal = $qty_retur * $harga_satuan;

                ReturPenjualanDetail::create([
                    'retur_penjualan_id' => $retur->id,
                    'barang_id' => $barang_id,
                    'qty' => $qty_retur,
                    'harga_satuan' => $harga_satuan, // ✅ Ditambahkan
                    'subtotal' => $subtotal,         // ✅ Ditambahkan
                ]);

                $barang->stok -= $qty_retur;
                $barang->save();

                // ✅ PERBAIKAN: Total retur biasanya menjumlahkan uang (subtotal), bukan qty
                $total_retur += $subtotal; 
            }

            $retur->update(['total_retur' => $total_retur]);

            DB::commit();
            return redirect()->route('retur-penjualan.index')->with('success', 'Retur Penjualan berhasil dicatat. Stok barang telah dikurangi.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', $e->getMessage());
        }
    }

    public function show($id)
    {
        // ✅ PERBAIKAN: Mengganti 'supplier' menjadi 'konsumen'
        $retur = ReturPenjualan::with(['penjualan', 'konsumen', 'details.barang'])->findOrFail($id);
        return view('retur_penjualan.show', compact('retur'));
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $retur = ReturPenjualan::with('details')->findOrFail($id);
            
            // Batalkan Retur = Kembalikan stok masuk ke gudang lagi
            foreach ($retur->details as $detail) {
                $barang = Barang::find($detail->barang_id);
                if ($barang) {
                    $barang->stok += $detail->qty;
                    $barang->save();
                }
            }

            $retur->delete();

            DB::commit();
            return back()->with('success', 'Data Retur dibatalkan. Stok barang telah dikembalikan ke gudang.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal membatalkan retur: ' . $e->getMessage());
        }
    }
}