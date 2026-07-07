<?php

namespace App\Http\Controllers;

use App\Models\ReturPembelian;
use App\Models\ReturPembelianDetail;
use App\Models\Pembelian;
use App\Models\Barang;
use App\Http\Requests\ReturPembelianRequest;
use Illuminate\Support\Facades\DB;

class ReturPembelianController extends Controller
{
    public function index()
    {
        $returs = ReturPembelian::with(['pembelian', 'supplier'])->latest()->paginate(10);
        return view('retur_pembelian.index', compact('returs'));
    }

    public function create()
    {
        // Menampilkan daftar pembelian untuk referensi retur
        $pembelians = Pembelian::with('supplier')->latest()->get();
        $barangs = Barang::where('stok', '>', 0)->orderBy('judul')->get();
        
        // Generate Nomor Bukti Retur Otomatis
        $date = date('Ymd');
        $last = ReturPembelian::whereDate('created_at', date('Y-m-d'))->orderBy('id', 'desc')->first();
        
        $nextNumber = $last ? intval(substr($last->no_retur, -3)) + 1 : 1;
        $no_retur = 'RB-' . $date . '-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        return view('retur_pembelian.create', compact('pembelians', 'barangs', 'no_retur'));
    }

    public function store(ReturPembelianRequest $request)
    {
        DB::beginTransaction();
        try {
            // 1. Buat Header Retur
            $retur = ReturPembelian::create([
                'no_retur' => $request->no_retur,
                'tgl_retur' => $request->tgl_retur,
                'pembelian_id' => $request->pembelian_id,
                'supplier_id' => $request->supplier_id,
                'alasan' => $request->keterangan,
            ]);

            // 2. Simpan Detail dan Kurangi Stok Barang
            foreach ($request->barang_id as $key => $barang_id) {
                $qty_retur = $request->qty[$key];
                $barang = Barang::find($barang_id);

                // Validasi agar tidak meretur barang melebihi stok yang ada di gudang
                if ($qty_retur > $barang->stok) {
                    throw new \Exception("Stok {$barang->judul} di gudang tidak mencukupi untuk diretur! Sisa: {$barang->stok}");
                }

                ReturPembelianDetail::create([
                    'retur_pembelian_id' => $retur->id,
                    'barang_id' => $barang_id,
                    'qty' => $qty_retur,
                ]);

                // KURANGI STOK KARENA BARANG DIKEMBALIKAN KE SUPPLIER
                $barang->stok -= $qty_retur;
                $barang->save();
            }

            DB::commit();
            return redirect()->route('retur-pembelian.index')->with('success', 'Retur Pembelian berhasil dicatat. Stok barang telah dikurangi.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', $e->getMessage());
        }
    }

    public function show($id)
    {
        $retur = ReturPembelian::with(['pembelian', 'supplier', 'details.barang'])->findOrFail($id);
        return view('retur_pembelian.show', compact('retur'));
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $retur = ReturPembelian::with('details')->findOrFail($id);
            
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