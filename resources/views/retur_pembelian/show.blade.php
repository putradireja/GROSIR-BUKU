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
    <div class="card-header bg-secondary text-white">
        <h5 class="mb-0">Detail Retur Pembelian</h5>
    </div>
    <div class="card-body">
        <div class="row mb-4">
            <div class="col-md-6">
                <table class="table table-borderless table-sm">
                    <tr><td width="150px">No. Retur</td><td>: <b>{{ $retur->no_retur }}</b></td></tr>
                    <tr><td>Tanggal</td><td>: {{ \Carbon\Carbon::parse($retur->tgl_retur)->format('d F Y') }}</td></tr>
                    <tr><td>Ref Pembelian</td><td>: <a href="{{ route('pembelian.show', $retur->pembelian_id) }}" class="no-print">{{ $retur->pembelian->no_beli }}</a><span class="d-none d-print-inline">{{ $retur->pembelian->no_beli }}</span></td></tr>
                    <tr><td>Keterangan</td><td>: <span class="text-danger">{{ $retur->keterangan ?? '-' }}</span></td></tr>
                </table>
            </div>
            <div class="col-md-6">
                <div class="border p-3 rounded bg-light">
                    <h6>Dikembalikan Kepada (Supplier):</h6>
                    <strong>{{ $retur->supplier->nama }}</strong><br>
                    {{ $retur->supplier->alamat }}<br>
                    Telp: {{ $retur->supplier->telepon }}
                </div>
            </div>
        </div>

        <h6 class="border-bottom pb-2">Daftar Barang Dikembalikan</h6>
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th width="50px">No</th>
                    <th>Kode Barang</th>
                    <th>Judul Buku</th>
                    <th width="150px">Qty Diretur</th>
                </tr>
            </thead>
            <tbody>
                @foreach($retur->details as $detail)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $detail->barang->kode }}</td>
                    <td>{{ $detail->barang->judul }}</td>
                    <td><span class="badge bg-danger fs-6">{{ $detail->qty }} Item</span></td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-3 no-print">
            <button onclick="window.print()" class="btn btn-secondary me-2">Cetak Surat Jalan Retur</button>
            <a href="{{ route('retur-pembelian.index') }}" class="btn btn-outline-secondary">Kembali</a>
        </div>
    </div>
</div>
</div>
@endsection