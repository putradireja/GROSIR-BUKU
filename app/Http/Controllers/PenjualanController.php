<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use App\Models\Konsumen;
use App\Models\Supplier;
use App\Models\Barang;
use App\Http\Requests\PenjualanRequest;
use Illuminate\Support\Facades\DB;

class PenjualanController extends Controller
{
    public function index()
    {
        $penjualans = Penjualan::with('supplier')->latest()->paginate(10);
        return view('penjualan.index', compact('penjualans'));
    }

    public function create()
    {
        $konsumens = Konsumen::orderBy('nama')->get();
        $suppliers = Supplier::orderBy('nama')->get();
        // Hanya tampilkan barang yang stoknya lebih dari 0
        $barangs = Barang::where('stok', '>', 0)->orderBy('judul')->get();
        
        // Auto Number PJ-YYYYMMDD-XXX
        $date = date('Ymd');
        $last = Penjualan::whereDate('created_at', date('Y-m-d'))->count() + 1;
        $no_jual = 'PJ-' . $date . '-' . str_pad($last, 3, '0', STR_PAD_LEFT);

        return view('penjualan.create', compact('konsumens', 'suppliers', 'barangs', 'no_jual'));
    }

    public function store(PenjualanRequest $request)
    {
        DB::beginTransaction();
        try {
            $total_semua = 0;
            $status_bayar = ($request->tipe == 'cash') ? 'lunas' : 'belum';

            $penjualan = Penjualan::create([
                'no_jual' => $request->no_jual,
                'tgl_jual' => $request->tgl_jual,
                'konsumen_id' => $request->konsumen_id,
                'supplier_id' => $request->supplier_id,
                'tipe' => $request->tipe,
                'jatuh_tempo' => $request->tipe == 'credit' ? $request->jatuh_tempo : null,
                'status_bayar' => $status_bayar,
                'total' => 0
            ]);

            foreach ($request->barang_id as $key => $barang_id) {
                $barang = Barang::find($barang_id);
                $qty = $request->qty[$key];
                
                // Validasi Stok Backend (Mencegah Bypass dari Inspect Element)
                if ($qty > $barang->stok) {
                    throw new \Exception("Stok buku '{$barang->judul}' tidak mencukupi! Sisa stok: {$barang->stok}");
                }

                $harga = $request->harga_satuan[$key];
                $diskon = $request->diskon[$key] ?? 0;
                $subtotal = ($qty * $harga) - $diskon;
                $total_semua += $subtotal;

                PenjualanDetail::create([
                    'penjualan_id' => $penjualan->id,
                    'barang_id' => $barang_id,
                    'qty' => $qty,
                    'harga_satuan' => $harga,
                    'diskon' => $diskon,
                    'subtotal' => $subtotal
                ]);

                // Update Stok Barang (KURANGI STOK)
                $barang->stok -= $qty;
                $barang->save();
            }

            // Update Total Penjualan
            $penjualan->update(['total' => $total_semua]);

            DB::commit();
            return redirect()->route('penjualan.index')->with('success', 'Penjualan berhasil diproses. Stok barang telah dikurangi.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', $e->getMessage());
        }
    }

    public function show($id)
    {
        $penjualan = Penjualan::with(['konsumen', 'details.barang'])->findOrFail($id);
        return view('penjualan.show', compact('penjualan'));
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $penjualan = Penjualan::with('details')->findOrFail($id);
            
            // Kembalikan stok barang ke etalase sebelum data penjualan dihapus
            foreach ($penjualan->details as $detail) {
                $barang = Barang::find($detail->barang_id);
                if ($barang) {
                    $barang->stok += $detail->qty;
                    $barang->save();
                }
            }

            $penjualan->delete();
            DB::commit();
            return back()->with('success', 'Transaksi Penjualan dihapus dan stok barang dikembalikan.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}