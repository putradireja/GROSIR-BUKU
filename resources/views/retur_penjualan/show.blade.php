@extends('layouts.app')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-secondary text-white">
        <h5 class="mb-0">Detail Retur Penjualan</h5>
    </div>
    <div class="card-body">
        <div class="row mb-4">
            <div class="col-md-6">
                <table class="table table-borderless table-sm">
                    <tr><td width="150px">No. Retur</td><td>: <b>{{ $retur->no_retur }}</b></td></tr>
                    <tr><td>Tanggal</td><td>: {{ \Carbon\Carbon::parse($retur->tgl_retur)->format('d F Y') }}</td></tr>
                    <tr><td>Ref Penjualan</td><td>: <a href="{{ route('penjualan.show', $retur->penjualan_id) }}">{{ $retur->penjualan->no_jual }}</a></td></tr>
                    <tr><td>Alasan Retur</td><td>: <span class="text-danger">{{ $retur->alasan ?? '-' }}</span></td></tr>
                </table>
            </div>
            <div class="col-md-6">
                <div class="border p-3 rounded bg-light">
                    <h6>Konsumen Pelanggan:</h6>
                    <strong>{{ $retur->konsumen->nama ?? 'Tanpa Konsumen' }}</strong><br>
                    {{ $retur->konsumen->alamat ?? '-' }}<br>
                    Telp: {{ $retur->konsumen->telepon ?? '-' }}
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

        <button onclick="window.print()" class="btn btn-secondary mt-3">Cetak Surat Jalan Retur</button>
        <a href="{{ route('retur-penjualan.index') }}" class="btn btn-outline-secondary mt-3">Kembali</a>
    </div>
</div>
@endsection