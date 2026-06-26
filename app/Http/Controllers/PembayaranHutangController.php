<?php

namespace App\Http\Controllers;

use App\Models\PembayaranHutang;
use App\Models\Pembelian;
use App\Http\Requests\PembayaranHutangRequest;
use Illuminate\Support\Facades\DB;

class PembayaranHutangController extends Controller
{
    public function index()
    {
        $pembayarans = PembayaranHutang::with(['pembelian', 'supplier'])->latest()->paginate(10);
        return view('pembayaran_hutang.index', compact('pembayarans'));
    }

    public function create()
    {
        // Ambil data Pembelian credit yang belum lunas
        $pembelians = Pembelian::with('supplier')
            ->where('tipe', 'credit')
            ->where('status_bayar', 'belum')
            ->get()
            ->map(function ($pb) {
                // Hitung total cicilan yang sudah dibayarkan ke supplier ini
                $terbayar = PembayaranHutang::where('pembelian_id', $pb->id)->sum('jumlah_bayar');
                $pb->sisa_hutang = $pb->total - $terbayar;
                return $pb;
            })
            // Filter hanya yang masih punya sisa hutang
            ->filter(function ($pb) {
                return $pb->sisa_hutang > 0;
            });

        // Generate Nomor Bukti Bayar Otomatis
        $date = date('Ymd');
        $last = PembayaranHutang::whereDate('created_at', date('Y-m-d'))->orderBy('id', 'desc')->first();
        
        if ($last) {
            $lastNumber = intval(substr($last->no_bayar, -3));
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 1;
        }
        
        $no_bayar = 'BYR-' . $date . '-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        return view('pembayaran_hutang.create', compact('pembelians', 'no_bayar'));
    }

    public function store(PembayaranHutangRequest $request)
    {
        DB::beginTransaction();
        try {
            $pembelian = Pembelian::findOrFail($request->pembelian_id);
            $jumlah_bayar = $request->jumlah_bayar;
            $sisa_sebelumnya = $request->total_hutang;

            // Validasi agar tidak bayar melebihi sisa hutang
            if ($jumlah_bayar > $sisa_sebelumnya) {
                throw new \Exception("Jumlah bayar melebihi sisa hutang! Sisa Hutang: Rp " . number_format($sisa_sebelumnya, 0, ',', '.'));
            }

            $sisa_sekarang = $sisa_sebelumnya - $jumlah_bayar;

            // Simpan pembayaran
            PembayaranHutang::create([
                'no_bayar' => $request->no_bayar,
                'tgl_bayar' => $request->tgl_bayar,
                'pembelian_id' => $pembelian->id,
                'supplier_id' => $request->supplier_id,
                'total_hutang' => $sisa_sebelumnya,
                'jumlah_bayar' => $jumlah_bayar,
                'sisa_hutang' => $sisa_sekarang,
                'ket' => $request->ket,
            ]);

            // Lunas otomatis
            if ($sisa_sekarang <= 0) {
                $pembelian->update(['status_bayar' => 'lunas']);
            }

            DB::commit();
            return redirect()->route('pembayaran-hutang.index')->with('success', 'Pembayaran hutang kepada supplier berhasil dicatat.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', $e->getMessage());
        }
    }

    public function show($id)
    {
        $pembayaran = PembayaranHutang::with(['pembelian', 'supplier'])->findOrFail($id);
        return view('pembayaran_hutang.show', compact('pembayaran'));
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $pembayaran = PembayaranHutang::findOrFail($id);
            $pembelian = Pembelian::findOrFail($pembayaran->pembelian_id);
            
            $pembayaran->delete();

            // Pengecekan ulang status lunas
            $total_bayar = PembayaranHutang::where('pembelian_id', $pembelian->id)->sum('jumlah_bayar');
            if ($total_bayar < $pembelian->total) {
                $pembelian->update(['status_bayar' => 'belum']);
            }

            DB::commit();
            return back()->with('success', 'Data pembayaran hutang dibatalkan.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}