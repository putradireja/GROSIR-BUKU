@extends('layouts.app')

@section('title', 'Edit Konsumen')

@section('content')
<x-card title="Edit Data Konsumen" subtitle="Perbarui data konsumen {{ $konsumen->nama }}">
    <form action="{{ route('master.konsumen.update', $konsumen->id) }}" method="POST" class="flex flex-col gap-5">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
            <div>
                <x-input-label for="kode" value="Kode Konsumen" />
                <x-text-input id="kode" name="kode" class="mt-1.5" value="{{ old('kode', $konsumen->kode) }}" />
                <x-input-error :messages="$errors->get('kode')" class="mt-1.5" />
            </div>
            <div>
                <x-input-label for="nama" value="Nama Konsumen" />
                <x-text-input id="nama" name="nama" class="mt-1.5" value="{{ old('nama', $konsumen->nama) }}" />
                <x-input-error :messages="$errors->get('nama')" class="mt-1.5" />
            </div>
            <div>
                <x-input-label for="telepon" value="Nomor Telepon" />
                <x-text-input id="telepon" name="telepon" class="mt-1.5" value="{{ old('telepon', $konsumen->telepon) }}" />
                <x-input-error :messages="$errors->get('telepon')" class="mt-1.5" />
            </div>
            <div>
                <x-input-label for="email" value="Alamat Email" />
                <x-text-input id="email" name="email" type="email" class="mt-1.5" value="{{ old('email', $konsumen->email) }}" />
                <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
            </div>
            <div class="sm:col-span-2">
                <x-input-label for="alamat" value="Alamat Lengkap" />
                <textarea id="alamat" name="alamat" rows="3" class="mt-1.5 w-full rounded-lg border-gray-300 focus:border-purple-500 focus:ring-purple-200">{{ old('alamat', $konsumen->alamat) }}</textarea>
                <x-input-error :messages="$errors->get('alamat')" class="mt-1.5" />
            </div>
        </div>

        <div class="flex items-center gap-3 border-t border-purple-50 pt-5">
            <x-button type="submit" variant="primary">Perbarui Konsumen</x-button>
            <x-button as="a" href="{{ route('master.konsumen.index') }}" variant="ghost">Batal</x-button>
        </div>
    </form>
</x-card>
@endsection