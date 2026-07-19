@extends('layouts.app')

@section('title', 'Bukti Pembayaran Piutang')

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
<x-card title="BUKTI TANDA TERIMA PEMBAYARAN" subtitle="Dokumen sah bukti penerimaan pembayaran" class="text-center">
    <x-slot name="headerClass">bg-gray-900 text-white</x-slot>

    <div class="mt-6">
        <dl class="space-y-3 text-left">
            <div class="flex gap-3">
                <dt class="w-36 text-sm font-medium text-slate-500">No. Tanda Terima</dt>
                <dd class="text-sm font-semibold text-slate-800">: {{ $penagihan->no_tagih }}</dd>
            </div>
            <div class="flex gap-3">
                <dt class="w-36 text-sm font-medium text-slate-500">Tanggal Diterima</dt>
                <dd class="text-sm text-slate-800">: {{ \Carbon\Carbon::parse($penagihan->tgl_tagih)->format('d F Y') }}</dd>
            </div>
            <div class="flex gap-3">
                <dt class="w-36 text-sm font-medium text-slate-500">Diterima Dari</dt>
                <dd class="text-sm font-semibold text-slate-800">: {{ $penagihan->konsumen->nama }}</dd>
            </div>
            <div class="flex gap-3">
                <dt class="w-36 text-sm font-medium text-slate-500">Untuk Pembayaran</dt>
                <dd class="text-sm text-slate-800">: Ref. Penjualan {{ $penagihan->penjualan->no_jual }}</dd>
            </div>

            <hr class="my-4 border-purple-100">

            <div class="flex gap-3">
                <dt class="w-36 text-sm font-medium text-slate-500">Sisa Piutang Awal</dt>
                <dd class="text-sm text-slate-800">: Rp {{ number_format($penagihan->total_piutang, 0, ',', '.') }}</dd>
            </div>
            <div class="flex gap-3">
                <dt class="w-36 text-base font-semibold text-slate-700">Jumlah Dibayar</dt>
                <dd class="text-base font-bold text-green-600">: Rp {{ number_format($penagihan->jumlah_bayar, 0, ',', '.') }}</dd>
            </div>

            <hr class="my-4 border-purple-100">

            <div class="flex gap-3">
                <dt class="w-36 text-sm font-medium text-slate-500">Sisa Piutang Akhir</dt>
                <dd class="text-sm">
                    : 
                    @if($penagihan->sisa_piutang <= 0)
                        <x-badge color="green">LUNAS</x-badge>
                    @else
                        <span class="font-bold text-red-600">Rp {{ number_format($penagihan->sisa_piutang, 0, ',', '.') }}</span>
                    @endif
                </dd>
            </div>
            <div class="flex gap-3">
                <dt class="w-36 text-sm font-medium text-slate-500">Keterangan</dt>
                <dd class="text-sm text-slate-800">: {{ $penagihan->ket ?? '-' }}</dd>
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
        <x-button as="a" href="{{ route('penagihan.index') }}" variant="ghost">Kembali</x-button>
    </div>
</x-card>
</div>
@endsection