@extends('layouts.app')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-dark text-white">
        <h5 class="mb-0">Tambah Data Barang</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('master.barang.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label>Kode Barang</label>
                    <input type="text" name="kode" class="form-control @error('kode') is-invalid @enderror" value="{{ old('kode') }}">
                    @error('kode') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-8 mb-3">
                    <label>Judul Buku</label>
                    <input type="text" name="judul" class="form-control @error('judul') is-invalid @enderror" value="{{ old('judul') }}">
                    @error('judul') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label>Pengarang</label>
                    <input type="text" name="pengarang" class="form-control @error('pengarang') is-invalid @enderror" value="{{ old('pengarang') }}">
                    @error('pengarang') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label>Penerbit</label>
                    <input type="text" name="penerbit" class="form-control @error('penerbit') is-invalid @enderror" value="{{ old('penerbit') }}">
                    @error('penerbit') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label>Kategori</label>
                    <input type="text" name="kategori" class="form-control @error('kategori') is-invalid @enderror" value="{{ old('kategori') }}">
                    @error('kategori') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label>Harga Beli</label>
                    <input type="number" name="harga_beli" class="form-control @error('harga_beli') is-invalid @enderror" value="{{ old('harga_beli') }}">
                    @error('harga_beli') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label>Harga Jual</label>
                    <input type="number" name="harga_jual" class="form-control @error('harga_jual') is-invalid @enderror" value="{{ old('harga_jual') }}">
                    @error('harga_jual') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label>Stok Awal</label>
                    <input type="number" name="stok" class="form-control @error('stok') is-invalid @enderror" value="{{ old('stok', 0) }}">
                    @error('stok') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>
            <hr>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('master.barang.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection