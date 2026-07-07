@extends('layouts.app')

@section('content')
<style>
@media print {
    body * { visibility: hidden; }
    #printArea, #printArea * { visibility: visible; }
    #printArea { position: absolute; left: 0; top: 0; width: 100%; }
    .no-print { display: none !important; }
    table, thead, tbody, tr, td { page-break-inside: avoid; break-inside: avoid; }
}
</style>

<div id="printArea">
<div class="card shadow-sm border-0" style="max-width: 650px; margin: auto;">
    <div class="card-header bg-dark text-white text-center">
        <h5 class="mb-0">BUKTI TANDA TERIMA PEMBAYARAN</h5>
    </div>
    <div class="card-body">
        <table class="table table-borderless table-sm">
            <tr>
                <td width="35%">No. Tanda Terima</td>
                <td>: <b>{{ $penagihan->no_tagih }}</b></td>
            </tr>
            <tr>
                <td>Tanggal Diterima</td>
                <td>: {{ \Carbon\Carbon::parse($penagihan->tgl_tagih)->format('d F Y') }}</td>
            </tr>
            <tr>
                <td>Diterima Dari</td>
                <td>: <b>{{ $penagihan->konsumen->nama }}</b></td>
            </tr>
            <tr>
                <td>Untuk Pembayaran</td>
                <td>: Ref. Penjualan <b>{{ $penagihan->penjualan->no_jual }}</b></td>
            </tr>
            <tr>
                <td colspan="2"><hr class="my-1"></td>
            </tr>
            <tr>
                <td>Sisa Hutang Awal</td>
                <td>: Rp {{ number_format($penagihan->total_piutang, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="fs-5">Jumlah Dibayar</td>
                <td class="fs-5 fw-bold text-success">: Rp {{ number_format($penagihan->jumlah_bayar, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td colspan="2"><hr class="my-1"></td>
            </tr>
            <tr>
                <td>Sisa Piutang Akhir</td>
                <td>: 
                    @if($penagihan->sisa_piutang <= 0)
                        <span class="badge bg-success">LUNAS</span>
                    @else
                        <span class="text-danger fw-bold">Rp {{ number_format($penagihan->sisa_piutang, 0, ',', '.') }}</span>
                    @endif
                </td>
            </tr>
            <tr>
                <td>Keterangan</td>
                <td>: {{ $penagihan->ket ?? '-' }}</td>
            </tr>
        </table>
        
        <div class="text-center mt-4 border-top pt-3 no-print">
            <button onclick="window.print()" class="btn btn-success me-2">
                Cetak Bukti
            </button>
            <a href="{{ route('penagihan.index') }}" class="btn btn-secondary">
                Kembali
            </a>
        </div>
    </div>
</div>
</div>
@endsection