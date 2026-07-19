@extends('layouts.app')

@section('title', 'Edit Barang')

@section('content')
<x-card title="Edit Data Barang" subtitle="Perbarui detail buku {{ $barang->judul }}">
    <form action="{{ route('master.barang.update', $barang->id) }}" method="POST" class="flex flex-col gap-5">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
            <div>
                <x-input-label for="kode" value="Kode Barang" />
                <x-text-input id="kode" name="kode" class="mt-1.5" value="{{ old('kode', $barang->kode) }}" />
                <x-input-error :messages="$errors->get('kode')" class="mt-1.5" />
            </div>
            <div class="sm:col-span-2">
                <x-input-label for="judul" value="Judul Buku" />
                <x-text-input id="judul" name="judul" class="mt-1.5" value="{{ old('judul', $barang->judul) }}" />
                <x-input-error :messages="$errors->get('judul')" class="mt-1.5" />
            </div>
            <div>
                <x-input-label for="pengarang" value="Pengarang" />
                <x-text-input id="pengarang" name="pengarang" class="mt-1.5" value="{{ old('pengarang', $barang->pengarang) }}" />
                <x-input-error :messages="$errors->get('pengarang')" class="mt-1.5" />
            </div>
            <div>
                <x-input-label for="penerbit" value="Penerbit" />
                <x-text-input id="penerbit" name="penerbit" class="mt-1.5" value="{{ old('penerbit', $barang->penerbit) }}" />
                <x-input-error :messages="$errors->get('penerbit')" class="mt-1.5" />
            </div>
            <div>
                <x-input-label for="kategori" value="Kategori" />
                <x-text-input id="kategori" name="kategori" class="mt-1.5" value="{{ old('kategori', $barang->kategori) }}" />
                <x-input-error :messages="$errors->get('kategori')" class="mt-1.5" />
            </div>
            <div>
                <x-input-label for="harga_beli" value="Harga Beli" />
                <x-text-input id="harga_beli" type="number" name="harga_beli" class="mt-1.5" value="{{ old('harga_beli', $barang->harga_beli) }}" />
                <x-input-error :messages="$errors->get('harga_beli')" class="mt-1.5" />
            </div>
            <div>
                <x-input-label for="harga_jual" value="Harga Jual" />
                <x-text-input id="harga_jual" type="number" name="harga_jual" class="mt-1.5" value="{{ old('harga_jual', $barang->harga_jual) }}" />
                <x-input-error :messages="$errors->get('harga_jual')" class="mt-1.5" />
            </div>
            <div>
                <x-input-label for="stok" value="Stok" />
                <x-text-input id="stok" type="number" name="stok" class="mt-1.5" value="{{ old('stok', $barang->stok) }}" />
                <x-input-error :messages="$errors->get('stok')" class="mt-1.5" />
            </div>
        </div>

        <div class="flex items-center gap-3 border-t border-purple-50 pt-5">
            <x-button type="submit" variant="primary">Update Barang</x-button>
            <x-button as="a" href="{{ route('master.barang.index') }}" variant="ghost">Batal</x-button>
        </div>
    </form>
</x-card>
@endsection