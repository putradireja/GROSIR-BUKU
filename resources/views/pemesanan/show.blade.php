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
    <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Detail Pemesanan</h5>
        <span class="badge bg-light text-dark fs-6">{{ strtoupper($pemesanan->status) }}</span>
    </div>
    <div class="card-body">
        <div class="row mb-4">
            <div class="col-md-6">
                <table class="table table-borderless table-sm">
                    <tr><td width="150px">No. Pesanan</td><td>: <b>{{ $pemesanan->no_pesan }}</b></td></tr>
                    <tr><td>Tanggal</td><td>: {{ \Carbon\Carbon::parse($pemesanan->tgl_pesan)->format('d F Y') }}</td></tr>
                    <tr><td>Catatan</td><td>: {{ $pemesanan->catatan ?? '-' }}</td></tr>
                </table>
            </div>
            <div class="col-md-6">
                <div class="border p-3 rounded bg-light">
                    <h6>Supplier:</h6>
                    <strong>{{ $pemesanan->supplier->nama }}</strong><br>
                    {{ $pemesanan->supplier->alamat }}<br>
                    Telp: {{ $pemesanan->supplier->telepon }}
                </div>
            </div>
        </div>

        <h6 class="border-bottom pb-2">Daftar Barang</h6>
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Kode</th>
                    <th>Judul Buku</th>
                    <th>Harga Satuan</th>
                    <th>Qty</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach($pemesanan->details as $detail)
                @php 
                    $subtotal = $detail->harga_satuan * $detail->qty;
                    $total += $subtotal;
                @endphp
                <tr>
                    <td>{{ $detail->barang->kode }}</td>
                    <td>{{ $detail->barang->judul }}</td>
                    <td>Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                    <td>{{ $detail->qty }}</td>
                    <td>Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot class="table-light">
                <tr>
                    <td colspan="4" class="text-end"><strong>Total Estimasi:</strong></td>
                    <td><strong>Rp {{ number_format($total, 0, ',', '.') }}</strong></td>
                </tr>
            </tfoot>
        </table>

        <div class="mt-3 no-print">
            <button onclick="window.print()" class="btn btn-success me-2">Cetak Bukti Pemesanan</button>
            <a href="{{ route('pemesanan.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>
</div>
@endsection