<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use App\Models\PemesananDetail;
use App\Models\Supplier;
use App\Models\Barang;
use App\Http\Requests\PemesananRequest;
use Illuminate\Support\Facades\DB;

class PemesananController extends Controller
{
    public function index()
    {
        $pemesanans = Pemesanan::with('supplier')->latest()->paginate(10);
        return view('pemesanan.index', compact('pemesanans'));
    }

    public function create()
    {
        $suppliers = Supplier::orderBy('nama')->get();
        $barangs = Barang::orderBy('judul')->get();
        
        // Generate Auto Number: PO-YYYYMMDD-XXX
        $date = date('Ymd');
        $lastPO = Pemesanan::whereDate('created_at', date('Y-m-d'))->count() + 1;
        $no_pesan = 'PO-' . $date . '-' . str_pad($lastPO, 3, '0', STR_PAD_LEFT);

        return view('pemesanan.create', compact('suppliers', 'barangs', 'no_pesan'));
    }

    public function store(PemesananRequest $request)
    {
        DB::beginTransaction();
        try {
            $pemesanan = Pemesanan::create([
                'no_pesan' => $request->no_pesan,
                'tgl_pesan' => $request->tgl_pesan,
                'supplier_id' => $request->supplier_id,
                'catatan' => $request->catatan,
                'status' => 'pending'
            ]);

            foreach ($request->barang_id as $key => $barang_id) {
                PemesananDetail::create([
                    'pemesanan_id' => $pemesanan->id,
                    'barang_id' => $barang_id,
                    'qty' => $request->qty[$key],
                    'harga_satuan' => $request->harga_satuan[$key]
                ]);
            }

            DB::commit();
            return redirect()->route('pemesanan.index')->with('success', 'Pemesanan berhasil dibuat.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $pemesanan = Pemesanan::with(['supplier', 'details.barang'])->findOrFail($id);
        return view('pemesanan.show', compact('pemesanan'));
    }

    public function approve($id)
    {
        $pemesanan = Pemesanan::findOrFail($id);
        $pemesanan->update(['status' => 'approved']);
        return back()->with('success', 'Pemesanan disetujui. Siap untuk proses Pembelian.');
    }

    public function cancel($id)
    {
        $pemesanan = Pemesanan::findOrFail($id);
        $pemesanan->update(['status' => 'cancelled']);
        return back()->with('success', 'Pemesanan dibatalkan.');
    }

    public function destroy($id)
    {
        $pemesanan = Pemesanan::findOrFail($id);
        if ($pemesanan->status != 'pending') {
            return back()->with('error', 'Hanya pemesanan pending yang bisa dihapus.');
        }
        $pemesanan->delete();
        return back()->with('success', 'Data Pemesanan dihapus.');
    }
}