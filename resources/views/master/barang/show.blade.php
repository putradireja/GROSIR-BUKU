@extends('layouts.app')

@section('title', 'Detail Barang')

@section('content')
<x-card title="Detail Barang" subtitle="Informasi lengkap buku {{ $barang->judul }}">
    <x-slot name="actions">
        <x-button as="a" href="{{ route('master.barang.index') }}" variant="ghost">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
            </svg>
            Kembali
        </x-button>
    </x-slot>

    <dl class="grid grid-cols-1 gap-x-8 gap-y-5 sm:grid-cols-2">
        <div class="rounded-2xl bg-purple-50/50 px-4 py-3">
            <dt class="text-xs font-bold uppercase tracking-wide text-purple-400">Kode Barang</dt>
            <dd class="mt-1 text-sm font-semibold text-slate-700">{{ $barang->kode }}</dd>
        </div>
        <div class="rounded-2xl bg-purple-50/50 px-4 py-3">
            <dt class="text-xs font-bold uppercase tracking-wide text-purple-400">Judul Buku</dt>
            <dd class="mt-1 text-sm font-semibold text-slate-700">{{ $barang->judul }}</dd>
        </div>
        <div class="rounded-2xl bg-purple-50/50 px-4 py-3">
            <dt class="text-xs font-bold uppercase tracking-wide text-purple-400">Pengarang</dt>
            <dd class="mt-1 text-sm font-semibold text-slate-700">{{ $barang->pengarang }}</dd>
        </div>
        <div class="rounded-2xl bg-purple-50/50 px-4 py-3">
            <dt class="text-xs font-bold uppercase tracking-wide text-purple-400">Penerbit</dt>
            <dd class="mt-1 text-sm font-semibold text-slate-700">{{ $barang->penerbit }}</dd>
        </div>
        <div class="rounded-2xl bg-purple-50/50 px-4 py-3">
            <dt class="text-xs font-bold uppercase tracking-wide text-purple-400">Kategori</dt>
            <dd class="mt-1"><x-badge color="purple">{{ $barang->kategori }}</x-badge></dd>
        </div>
        <div class="rounded-2xl bg-purple-50/50 px-4 py-3">
            <dt class="text-xs font-bold uppercase tracking-wide text-purple-400">Stok Tersedia</dt>
            <dd class="mt-1"><x-badge :color="$barang->stok > 10 ? 'green' : 'red'">{{ $barang->stok }} pcs</x-badge></dd>
        </div>
        <div class="rounded-2xl bg-purple-50/50 px-4 py-3">
            <dt class="text-xs font-bold uppercase tracking-wide text-purple-400">Harga Beli</dt>
            <dd class="mt-1 text-sm font-semibold text-slate-700">Rp {{ number_format($barang->harga_beli, 0, ',', '.') }}</dd>
        </div>
        <div class="rounded-2xl bg-purple-50/50 px-4 py-3">
            <dt class="text-xs font-bold uppercase tracking-wide text-purple-400">Harga Jual</dt>
            <dd class="mt-1 text-sm font-semibold text-slate-700">Rp {{ number_format($barang->harga_jual, 0, ',', '.') }}</dd>
        </div>
    </dl>
</x-card>
@endsection