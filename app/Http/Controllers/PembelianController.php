<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use App\Models\PembelianDetail;
use App\Models\Pemesanan;
use App\Models\Supplier;
use App\Models\Barang;
use App\Http\Requests\PembelianRequest;
use Illuminate\Support\Facades\DB;

class PembelianController extends Controller
{
    public function index()
    {
        $pembelians = Pembelian::with('supplier')->latest()->paginate(10);
        return view('pembelian.index', compact('pembelians'));
    }

    public function create()
    {
        $suppliers = Supplier::orderBy('nama')->get();
        $barangs = Barang::orderBy('judul')->get();
        $pemesanans = Pemesanan::where('status', 'approved')->orderBy('no_pesan')->get();
        
        // Generate Auto Number yang lebih aman dari duplikat
        $date = date('Ymd');
        $lastPembelian = Pembelian::whereDate('created_at', date('Y-m-d'))->orderBy('id', 'desc')->first();
        
        if ($lastPembelian) {
            $lastNumber = intval(substr($lastPembelian->no_beli, -3));
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 1;
        }
        
        $no_beli = 'PB-' . $date . '-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        return view('pembelian.create', compact('suppliers', 'barangs', 'pemesanans', 'no_beli'));
    }

    public function store(PembelianRequest $request)
    {
        DB::beginTransaction();
        try {
            $total_semua = 0;
            // Jika Cash langsung Lunas, jika Credit jadi Belum Lunas (Hutang)
            $status_bayar = ($request->tipe == 'cash') ? 'lunas' : 'belum';

            $pembelian = Pembelian::create([
                'no_beli' => $request->no_beli,
                'tgl_beli' => $request->tgl_beli,
                'pemesanan_id' => $request->pemesanan_id,
                'tipe' => $request->tipe,
                'supplier_id' => $request->supplier_id,
                'jatuh_tempo' => $request->tipe == 'credit' ? $request->jatuh_tempo : null,
                'status_bayar' => $status_bayar,
                'total' => 0 // Akan di-update setelah rincian dihitung
            ]);

            foreach ($request->barang_id as $key => $barang_id) {
                $qty = $request->qty[$key];
                $harga = $request->harga_satuan[$key];
                $subtotal = $qty * $harga;
                $total_semua += $subtotal;

                PembelianDetail::create([
                    'pembelian_id' => $pembelian->id,
                    'barang_id' => $barang_id,
                    'qty' => $qty,
                    'harga_satuan' => $harga,
                    'subtotal' => $subtotal
                ]);

                // Update Stok Barang (TAMBAH STOK)
                $barang = Barang::find($barang_id);
                $barang->stok += $qty;
                $barang->save();
            }

            // Update Total Pembelian ke tabel induk
            $pembelian->update(['total' => $total_semua]);

            DB::commit();
            return redirect()->route('pembelian.index')->with('success', 'Pembelian berhasil diproses dan stok bertambah.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $pembelian = Pembelian::with(['supplier', 'pemesanan', 'details.barang'])->findOrFail($id);
        return view('pembelian.show', compact('pembelian'));
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $pembelian = Pembelian::with('details')->findOrFail($id);
            
            // Kembalikan (Kurangi) stok barang sebelum transaksi dihapus
            foreach ($pembelian->details as $detail) {
                $barang = Barang::find($detail->barang_id);
                if ($barang) {
                    $barang->stok -= $detail->qty;
                    $barang->save();
                }
            }

            $pembelian->delete();
            DB::commit();
            return back()->with('success', 'Data Pembelian dihapus dan stok telah dikembalikan.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}