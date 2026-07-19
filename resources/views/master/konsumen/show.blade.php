@extends('layouts.app')

@section('title', 'Detail Konsumen')

@section('content')
<x-card title="Detail Konsumen" subtitle="Informasi lengkap {{ $konsumen->nama }}">
    <x-slot name="actions">
        <x-button as="a" href="{{ route('master.konsumen.index') }}" variant="ghost">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
            </svg>
            Kembali
        </x-button>
    </x-slot>

    <dl class="grid grid-cols-1 gap-x-8 gap-y-5 sm:grid-cols-2">
        <div class="rounded-2xl bg-purple-50/50 px-4 py-3">
            <dt class="text-xs font-bold uppercase tracking-wide text-purple-400">Kode Konsumen</dt>
            <dd class="mt-1 text-sm font-semibold text-slate-700">{{ $konsumen->kode }}</dd>
        </div>
        <div class="rounded-2xl bg-purple-50/50 px-4 py-3">
            <dt class="text-xs font-bold uppercase tracking-wide text-purple-400">Nama Konsumen</dt>
            <dd class="mt-1 text-sm font-semibold text-slate-700">{{ $konsumen->nama }}</dd>
        </div>
        <div class="rounded-2xl bg-purple-50/50 px-4 py-3">
            <dt class="text-xs font-bold uppercase tracking-wide text-purple-400">Nomor Telepon</dt>
            <dd class="mt-1 text-sm font-semibold text-slate-700">{{ $konsumen->telepon }}</dd>
        </div>
        <div class="rounded-2xl bg-purple-50/50 px-4 py-3">
            <dt class="text-xs font-bold uppercase tracking-wide text-purple-400">Alamat Email</dt>
            <dd class="mt-1 text-sm font-semibold text-slate-700">{{ $konsumen->email }}</dd>
        </div>
        <div class="rounded-2xl bg-purple-50/50 px-4 py-3 sm:col-span-2">
            <dt class="text-xs font-bold uppercase tracking-wide text-purple-400">Alamat Lengkap</dt>
            <dd class="mt-1 text-sm font-semibold text-slate-700 whitespace-pre-line">{{ $konsumen->alamat }}</dd>
        </div>
    </dl>
</x-card>
@endsection