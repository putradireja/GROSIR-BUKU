<?php

namespace App\Http\Controllers;

use App\Models\Penagihan;
use App\Models\Penjualan;
use App\Http\Requests\PenagihanRequest;
use Illuminate\Support\Facades\DB;

class PenagihanController extends Controller
{
    public function index()
    {
        $penagihans = Penagihan::with(['penjualan', 'konsumen'])->latest()->paginate(10);
        return view('penagihan.index', compact('penagihans'));
    }

    public function create()
    {
        // Ambil data penjualan credit yang statusnya belum lunas
        $penjualans = Penjualan::with('konsumen')
            ->where('tipe', 'credit')
            ->where('status_bayar', 'belum')
            ->get()
            ->map(function ($pj) {
                // Hitung total uang yang sudah dibayarkan untuk transaksi ini
                $terbayar = Penagihan::where('penjualan_id', $pj->id)->sum('jumlah_bayar');
                $pj->sisa_piutang = $pj->total - $terbayar;
                return $pj;
            })
            // Hanya tampilkan yang sisa piutangnya lebih dari 0
            ->filter(function ($pj) {
                return $pj->sisa_piutang > 0;
            });

        // Generate Nomor Bukti Tagihan Otomatis
        $date = date('Ymd');
        $last = Penagihan::whereDate('created_at', date('Y-m-d'))->orderBy('id', 'desc')->first();
        
        if ($last) {
            $lastNumber = intval(substr($last->no_tagih, -3));
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 1;
        }
        
        $no_tagih = 'INV-' . $date . '-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        return view('penagihan.create', compact('penjualans', 'no_tagih'));
    }

    public function store(PenagihanRequest $request)
    {
        DB::beginTransaction();
        try {
            $penjualan = Penjualan::findOrFail($request->penjualan_id);
            $jumlah_bayar = $request->jumlah_bayar;
            $sisa_sebelumnya = $request->total_piutang;

            // Validasi: Jumlah bayar tidak boleh melebihi sisa hutang
            if ($jumlah_bayar > $sisa_sebelumnya) {
                throw new \Exception("Jumlah bayar melebihi sisa piutang! Sisa Piutang: Rp " . number_format($sisa_sebelumnya, 0, ',', '.'));
            }

            $sisa_sekarang = $sisa_sebelumnya - $jumlah_bayar;

            // Simpan data pembayaran
            Penagihan::create([
                'no_tagih' => $request->no_tagih,
                'tgl_tagih' => $request->tgl_tagih,
                'penjualan_id' => $penjualan->id,
                'konsumen_id' => $request->konsumen_id,
                'total_piutang' => $sisa_sebelumnya,
                'jumlah_bayar' => $jumlah_bayar,
                'sisa_piutang' => $sisa_sekarang,
                'ket' => $request->ket,
            ]);

            // Jika sisa hutang habis (0), update status Penjualan menjadi Lunas
            if ($sisa_sekarang <= 0) {
                $penjualan->update(['status_bayar' => 'lunas']);
            }

            DB::commit();
            return redirect()->route('penagihan.index')->with('success', 'Pembayaran piutang berhasil dicatat.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', $e->getMessage());
        }
    }

    public function show($id)
    {
        $penagihan = Penagihan::with(['penjualan', 'konsumen'])->findOrFail($id);
        return view('penagihan.show', compact('penagihan'));
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $penagihan = Penagihan::findOrFail($id);
            $penjualan = Penjualan::findOrFail($penagihan->penjualan_id);
            
            $penagihan->delete();

            // Cek ulang total bayar setelah data dihapus
            $total_bayar = Penagihan::where('penjualan_id', $penjualan->id)->sum('jumlah_bayar');
            
            // Jika total bayar jadi kurang dari total belanja, ubah statusnya kembali jadi "belum" (belum lunas)
            if ($total_bayar < $penjualan->total) {
                $penjualan->update(['status_bayar' => 'belum']);
            }

            DB::commit();
            return back()->with('success', 'Catatan pembayaran dibatalkan/dihapus.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}