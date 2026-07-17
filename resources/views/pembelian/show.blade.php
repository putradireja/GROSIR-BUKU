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
        <h5 class="mb-0">Detail Pembelian Barang Masuk</h5>
    </div>
    <div class="card-body">
        <div class="row mb-4">
            <div class="col-md-6">
                <table class="table table-borderless table-sm">
                    <tr><td width="150px">No. Pembelian</td><td>: <b>{{ $pembelian->no_beli }}</b></td></tr>
                    <tr><td>Tanggal</td><td>: {{ \Carbon\Carbon::parse($pembelian->tgl_beli)->format('d F Y') }}</td></tr>
                    <tr><td>Ref PO</td><td>: {{ $pembelian->pemesanan->no_pesan ?? 'Tanpa PO' }}</td></tr>
                    <tr><td>Tipe / Status</td><td>: 
                        <span class="badge {{ $pembelian->tipe == 'cash' ? 'bg-primary' : 'bg-danger' }}">{{ strtoupper($pembelian->tipe) }}</span>
                        <span class="badge {{ $pembelian->status_bayar == 'lunas' ? 'bg-success' : 'bg-warning text-dark' }}">{{ strtoupper($pembelian->status_bayar) }}</span>
                    </td></tr>
                    @if($pembelian->tipe == 'credit')
                    <tr><td>Jatuh Tempo</td><td>: <span class="text-danger fw-bold">{{ \Carbon\Carbon::parse($pembelian->jatuh_tempo)->format('d F Y') }}</span></td></tr>
                    @endif
                </table>
            </div>
            <div class="col-md-6">
                <div class="border p-3 rounded bg-light">
                    <h6>Supplier:</h6>
                    <strong>{{ $pembelian->supplier->nama }}</strong><br>
                    {{ $pembelian->supplier->alamat }}<br>
                    Telp: {{ $pembelian->supplier->telepon }}
                </div>
            </div>
        </div>

        <h6 class="border-bottom pb-2">Daftar Barang Diterima</h6>
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Kode</th>
                    <th>Judul Buku</th>
                    <th>Harga Beli</th>
                    <th>Qty Masuk</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pembelian->details as $detail)
                <tr>
                    <td>{{ $detail->barang->kode }}</td>
                    <td>{{ $detail->barang->judul }}</td>
                    <td>Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                    <td>{{ $detail->qty }}</td>
                    <td>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot class="table-light">
                <tr>
                    <td colspan="4" class="text-end"><strong>GRAND TOTAL:</strong></td>
                    <td><strong class="text-success fs-5">Rp {{ number_format($pembelian->total, 0, ',', '.') }}</strong></td>
                </tr>
            </tfoot>
        </table>

        <div class="mt-3 no-print">
            <button onclick="window.print()" class="btn btn-success me-2">Cetak Bukti Pembelian</button>
            <a href="{{ route('pembelian.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>
</div>
@endsection