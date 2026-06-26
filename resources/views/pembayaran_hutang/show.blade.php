@extends('layouts.app')

@section('content')
<div class="card shadow-sm border-0" style="max-width: 650px; margin: auto;">
    <div class="card-header bg-primary text-white text-center">
        <h5 class="mb-0">BUKTI PENGELUARAN KAS (BAYAR HUTANG)</h5>
    </div>
    <div class="card-body">
        <table class="table table-borderless table-sm">
            <tr>
                <td width="35%">No. Bukti Bayar</td>
                <td>: <b>{{ $pembayaran->no_bayar }}</b></td>
            </tr>
            <tr>
                <td>Tanggal Dibayar</td>
                <td>: {{ \Carbon\Carbon::parse($pembayaran->tgl_bayar)->format('d F Y') }}</td>
            </tr>
            <tr>
                <td>Dibayarkan Kepada</td>
                <td>: <b>{{ $pembayaran->supplier->nama }}</b></td>
            </tr>
            <tr>
                <td>Untuk Referensi</td>
                <td>: Pembelian <b>{{ $pembayaran->pembelian->no_beli }}</b></td>
            </tr>
            <tr>
                <td colspan="2"><hr class="my-1"></td>
            </tr>
            <tr>
                <td>Sisa Hutang Awal</td>
                <td>: Rp {{ number_format($pembayaran->total_hutang, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="fs-5">Jumlah Dibayarkan</td>
                <td class="fs-5 fw-bold text-primary">: Rp {{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td colspan="2"><hr class="my-1"></td>
            </tr>
            <tr>
                <td>Sisa Hutang Akhir</td>
                <td>: 
                    @if($pembayaran->sisa_hutang <= 0)
                        <span class="badge bg-success">LUNAS</span>
                    @else
                        <span class="text-danger fw-bold">Rp {{ number_format($pembayaran->sisa_hutang, 0, ',', '.') }}</span>
                    @endif
                </td>
            </tr>
            <tr>
                <td>Keterangan</td>
                <td>: {{ $pembayaran->ket ?? '-' }}</td>
            </tr>
        </table>
        
        <div class="text-center mt-4 border-top pt-3">
            <button onclick="window.print()" class="btn btn-primary me-2">
                Cetak Bukti Pengeluaran
            </button>
            <a href="{{ route('pembayaran-hutang.index') }}" class="btn btn-secondary">
                Kembali
            </a>
        </div>
    </div>
</div>
@endsection