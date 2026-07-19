@extends('layouts.app')

@section('title', 'Detail Supplier')

@section('content')
<x-card title="Detail Supplier" subtitle="Informasi lengkap {{ $supplier->nama }}">
    <x-slot name="actions">
        <x-button as="a" href="{{ route('master.supplier.index') }}" variant="ghost">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
            </svg>
            Kembali
        </x-button>
    </x-slot>

    <dl class="grid grid-cols-1 gap-x-8 gap-y-5 sm:grid-cols-2">
        <div class="rounded-2xl bg-purple-50/50 px-4 py-3">
            <dt class="text-xs font-bold uppercase tracking-wide text-purple-400">Kode Supplier</dt>
            <dd class="mt-1 text-sm font-semibold text-slate-700">{{ $supplier->kode }}</dd>
        </div>
        <div class="rounded-2xl bg-purple-50/50 px-4 py-3">
            <dt class="text-xs font-bold uppercase tracking-wide text-purple-400">Nama Supplier</dt>
            <dd class="mt-1 text-sm font-semibold text-slate-700">{{ $supplier->nama }}</dd>
        </div>
        <div class="rounded-2xl bg-purple-50/50 px-4 py-3">
            <dt class="text-xs font-bold uppercase tracking-wide text-purple-400">Nomor Telepon</dt>
            <dd class="mt-1 text-sm font-semibold text-slate-700">{{ $supplier->telepon }}</dd>
        </div>
        <div class="rounded-2xl bg-purple-50/50 px-4 py-3">
            <dt class="text-xs font-bold uppercase tracking-wide text-purple-400">Alamat Email</dt>
            <dd class="mt-1 text-sm font-semibold text-slate-700">{{ $supplier->email }}</dd>
        </div>
        <div class="rounded-2xl bg-purple-50/50 px-4 py-3 sm:col-span-2">
            <dt class="text-xs font-bold uppercase tracking-wide text-purple-400">Alamat Lengkap</dt>
            <dd class="mt-1 text-sm font-semibold text-slate-700 whitespace-pre-line">{{ $supplier->alamat }}</dd>
        </div>
    </dl>
</x-card>
@endsection