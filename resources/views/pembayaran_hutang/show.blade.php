@extends('layouts.app')

@section('content')
<style>
@media print {
    * {
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
        color-adjust: exact !important;
    }
    body * { visibility: hidden; }
    #printArea, #printArea * { visibility: visible; }
    #printArea { position: absolute; left: 0; top: 0; width: 100%; }
    .no-print { display: none !important; }
    table, thead, tbody, tr, td { page-break-inside: avoid; break-inside: avoid; }
}
</style>

<div id="printArea">
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

        <div class="text-center mt-4 border-top pt-3 no-print">
            <button onclick="window.print()" class="btn btn-success me-2">
                Cetak Bukti Pengeluaran
            </button>
            <a href="{{ route('pembayaran-hutang.index') }}" class="btn btn-secondary">
                Kembali
            </a>
        </div>
    </div>
</div>
</div>
@endsection