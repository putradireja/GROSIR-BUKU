@extends('layouts.app')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-info text-white">
        <h5 class="mb-0">Detail Barang</h5>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th width="200px" class="bg-light">Kode Barang</th>
                <td>{{ $barang->kode }}</td>
            </tr>
            <tr>
                <th class="bg-light">Judul Buku</th>
                <td>{{ $barang->judul }}</td>
            </tr>
            <tr>
                <th class="bg-light">Pengarang</th>
                <td>{{ $barang->pengarang }}</td>
            </tr>
            <tr>
                <th class="bg-light">Penerbit</th>
                <td>{{ $barang->penerbit }}</td>
            </tr>
            <tr>
                <th class="bg-light">Kategori</th>
                <td>{{ $barang->kategori }}</td>
            </tr>
            <tr>
                <th class="bg-light">Harga Beli</th>
                <td>Rp {{ number_format($barang->harga_beli, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <th class="bg-light">Harga Jual</th>
                <td>Rp {{ number_format($barang->harga_jual, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <th class="bg-light">Stok Tersedia</th>
                <td>{{ $barang->stok }}</td>
            </tr>
        </table>
        <a href="{{ route('master.barang.index') }}" class="btn btn-secondary mt-3">Kembali</a>
    </div>
</div>
@endsection