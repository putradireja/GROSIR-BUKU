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
<div class="card shadow-sm border-0">
    <div class="card-header bg-info text-white">
        <h5 class="mb-0">Detail Transaksi Penjualan</h5>
    </div>
    <div class="card-body">
        <div class="row mb-4">
            <div class="col-md-6">
                <table class="table table-borderless table-sm">
                    <tr><td width="150px">No. Penjualan</td><td>: <b>{{ $penjualan->no_jual }}</b></td></tr>
                    <tr><td>Tanggal</td><td>: {{ \Carbon\Carbon::parse($penjualan->tgl_jual)->format('d F Y') }}</td></tr>
                    <tr><td>Tipe / Status</td><td>: 
                        <span class="badge {{ $penjualan->tipe == 'cash' ? 'bg-primary' : 'bg-danger' }}">{{ strtoupper($penjualan->tipe) }}</span>
                        <span class="badge {{ $penjualan->status_bayar == 'lunas' ? 'bg-success' : 'bg-warning text-dark' }}">{{ strtoupper($penjualan->status_bayar) }}</span>
                    </td></tr>
                    @if($penjualan->tipe == 'credit')
                    <tr><td>Jatuh Tempo</td><td>: <span class="text-danger fw-bold">{{ \Carbon\Carbon::parse($penjualan->jatuh_tempo)->format('d F Y') }}</span></td></tr>
                    @endif
                </table>
            </div>
            <div class="col-md-6">
                <div class="border p-3 rounded bg-light">
                    <h6>Konsumen:</h6>
                    <strong>{{ $penjualan->konsumen->nama }}</strong><br>
                    {{ $penjualan->konsumen->alamat }}<br>
                    Telp: {{ $penjualan->konsumen->telepon }}
                </div>
            </div>
        </div>

        <h6 class="border-bottom pb-2">Daftar Barang Dibeli</h6>
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Kode</th>
                    <th>Judul Buku</th>
                    <th>Harga Jual</th>
                    <th>Qty</th>
                    <th>Diskon</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($penjualan->details as $detail)
                <tr>
                    <td>{{ $detail->barang->kode }}</td>
                    <td>{{ $detail->barang->judul }}</td>
                    <td>Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                    <td>{{ $detail->qty }}</td>
                    <td>Rp {{ number_format($detail->diskon, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot class="table-light">
                <tr>
                    <td colspan="5" class="text-end"><strong>GRAND TOTAL:</strong></td>
                    <td><strong class="text-danger fs-5">Rp {{ number_format($penjualan->total, 0, ',', '.') }}</strong></td>
                </tr>
            </tfoot>
        </table>

        <div class="mt-3 no-print">
            <button onclick="window.print()" class="btn btn-success me-2">Cetak Struk Penjualan</button>
            <a href="{{ route('penjualan.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>
</div>
@endsection