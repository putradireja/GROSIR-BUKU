@extends('layouts.app')

@section('title', 'Bukti Pengeluaran Kas')

@section('content')
<style>
@media print {
    * {
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
        -webkit-color-adjust: exact !important;
    }
    body * { visibility: hidden; }
    #printArea, #printArea * { visibility: visible; }
    #printArea { position: absolute; left: 50%; top: 2rem; transform: translateX(-50%); max-width: 650px; width: 100%; }
    .no-print { display: none !important; }
    table, thead, tbody, tr, td { page-break-inside: avoid; break-inside: avoid; }
}
</style>

<div id="printArea">
<x-card title="BUKTI PENGELUARAN KAS" subtitle="Dokumen sah bukti pembayaran hutang" class="text-center">
    <x-slot name="headerClass">bg-purple-600 text-white</x-slot>

    <div class="mt-6">
        <dl class="space-y-3 text-left">
            <div class="flex gap-3">
                <dt class="w-40 text-sm font-medium text-slate-500">No. Bukti Bayar</dt>
                <dd class="text-sm font-semibold text-slate-800">: {{ $pembayaran->no_bayar }}</dd>
            </div>
            <div class="flex gap-3">
                <dt class="w-40 text-sm font-medium text-slate-500">Tanggal Dibayar</dt>
                <dd class="text-sm text-slate-800">: {{ \Carbon\Carbon::parse($pembayaran->tgl_bayar)->format('d F Y') }}</dd>
            </div>
            <div class="flex gap-3">
                <dt class="w-40 text-sm font-medium text-slate-500">Dibayarkan Kepada</dt>
                <dd class="text-sm font-semibold text-slate-800">: {{ $pembayaran->supplier->nama }}</dd>
            </div>
            <div class="flex gap-3">
                <dt class="w-40 text-sm font-medium text-slate-500">Referensi Pembelian</dt>
                <dd class="text-sm text-slate-800">: {{ $pembayaran->pembelian->no_beli }}</dd>
            </div>

            <hr class="my-4 border-purple-100">

            <div class="flex gap-3">
                <dt class="w-40 text-sm font-medium text-slate-500">Sisa Hutang Awal</dt>
                <dd class="text-sm text-slate-800">: Rp {{ number_format($pembayaran->total_hutang, 0, ',', '.') }}</dd>
            </div>
            <div class="flex gap-3">
                <dt class="w-40 text-base font-semibold text-slate-700">Jumlah Dibayarkan</dt>
                <dd class="text-base font-bold text-purple-600">: Rp {{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}</dd>
            </div>

            <hr class="my-4 border-purple-100">

            <div class="flex gap-3">
                <dt class="w-40 text-sm font-medium text-slate-500">Sisa Hutang Akhir</dt>
                <dd class="text-sm">
                    : 
                    @if($pembayaran->sisa_hutang <= 0)
                        <x-badge color="green">LUNAS</x-badge>
                    @else
                        <span class="font-bold text-red-600">Rp {{ number_format($pembayaran->sisa_hutang, 0, ',', '.') }}</span>
                    @endif
                </dd>
            </div>
            <div class="flex gap-3">
                <dt class="w-40 text-sm font-medium text-slate-500">Keterangan</dt>
                <dd class="text-sm text-slate-800">: {{ $pembayaran->ket ?? '-' }}</dd>
            </div>
        </dl>
    </div>

    <div class="mt-8 flex items-center justify-center gap-3 border-t border-purple-50 pt-5 no-print">
        <button onclick="window.print()" class="inline-flex items-center gap-2 rounded-lg bg-green-600 px-5 py-2.5 text-sm font-medium text-white hover:bg-green-700 transition">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 19.25h10.56M6.72 4.75h10.56a2.25 2.25 0 0 1 2.25 2.25v9.75a2.25 2.25 0 0 1-2.25 2.25H6.72a2.25 2.25 0 0 1-2.25-2.25V7a2.25 2.25 0 0 1 2.25-2.25Z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 10.75h4.5M9.75 14.75h4.5" />
            </svg>
            Cetak Bukti
        </button>
        <x-button as="a" href="{{ route('pembayaran-hutang.index') }}" variant="ghost">Kembali</x-button>
    </div>
</x-card>
</div>
@endsection