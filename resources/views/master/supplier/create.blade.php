@extends('layouts.app')

@section('title', 'Tambah Supplier')

@section('content')
<x-card title="Tambah Data Supplier" subtitle="Lengkapi data pemasok baru">
    <form action="{{ route('master.supplier.store') }}" method="POST" class="flex flex-col gap-5">
        @csrf
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
            <div>
                <x-input-label for="kode" value="Kode Supplier" />
                <x-text-input id="kode" name="kode" class="mt-1.5" value="{{ old('kode') }}" placeholder="SUP-XXX" />
                <x-input-error :messages="$errors->get('kode')" class="mt-1.5" />
            </div>
            <div>
                <x-input-label for="nama" value="Nama Supplier" />
                <x-text-input id="nama" name="nama" class="mt-1.5" value="{{ old('nama') }}" placeholder="Nama lengkap pemasok" />
                <x-input-error :messages="$errors->get('nama')" class="mt-1.5" />
            </div>
            <div>
                <x-input-label for="telepon" value="Nomor Telepon" />
                <x-text-input id="telepon" name="telepon" class="mt-1.5" value="{{ old('telepon') }}" placeholder="021-xxxxxxx" />
                <x-input-error :messages="$errors->get('telepon')" class="mt-1.5" />
            </div>
            <div>
                <x-input-label for="email" value="Alamat Email" />
                <x-text-input id="email" name="email" type="email" class="mt-1.5" value="{{ old('email') }}" placeholder="email@contoh.com" />
                <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
            </div>
            <div class="sm:col-span-2">
                <x-input-label for="alamat" value="Alamat Lengkap" />
                <textarea id="alamat" name="alamat" rows="3" class="mt-1.5 w-full rounded-lg border-gray-300 focus:border-purple-500 focus:ring-purple-200" placeholder="Alamat kantor pemasok">{{ old('alamat') }}</textarea>
                <x-input-error :messages="$errors->get('alamat')" class="mt-1.5" />
            </div>
        </div>

        <div class="flex items-center gap-3 border-t border-purple-50 pt-5">
            <x-button type="submit" variant="primary">Simpan Supplier</x-button>
            <x-button as="a" href="{{ route('master.supplier.index') }}" variant="ghost">Batal</x-button>
        </div>
    </form>
</x-card>
@endsection