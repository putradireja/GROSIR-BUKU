@extends('layouts.app')

@section('title', 'Detail Transaksi Penjualan')

@section('content')
<style>
@media print {
    * {
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
        color: exact !important;
    }
    body * { visibility: hidden; }
    #printArea, #printArea * { visibility: visible; }
    #printArea { position: absolute; left: 0; top: 0; width: 100%; }
    .no-print { display: none !important; }
    table, thead, tbody, tr, td { page-break-inside: avoid; break-inside: avoid; }
}
</style>

<div id="printArea">
<x-card title="Detail Transaksi Penjualan" subtitle="Informasi lengkap struk penjualan">
    {{-- Info Utama & Konsumen --}}
    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 mb-6">
        <div class="rounded-2xl bg-purple-50/50 p-4">
            <dl class="space-y-2">
                <div class="flex items-center gap-3">
                    <dt class="w-32 text-xs font-bold uppercase tracking-wide text-purple-400">No. Penjualan</dt>
                    <dd class="text-sm font-semibold text-slate-700">{{ $penjualan->no_jual }}</dd>
                </div>
                <div class="flex items-center gap-3">
                    <dt class="w-32 text-xs font-bold uppercase tracking-wide text-purple-400">Tanggal</dt>
                    <dd class="text-sm text-slate-700">{{ \Carbon\Carbon::parse($penjualan->tgl_jual)->format('d F Y') }}</dd>
                </div>
                <div class="flex items-center gap-3">
                    <dt class="w-32 text-xs font-bold uppercase tracking-wide text-purple-400">Tipe / Status</dt>
                    <dd class="flex items-center gap-2">
                        <x-badge :color="$penjualan->tipe == 'cash' ? 'blue' : 'red'">{{ strtoupper($penjualan->tipe) }}</x-badge>
                        <x-badge :color="$penjualan->status_bayar == 'lunas' ? 'green' : 'warning'">{{ strtoupper($penjualan->status_bayar) }}</x-badge>
                    </dd>
                </div>
                @if($penjualan->tipe == 'credit')
                <div class="flex items-center gap-3">
                    <dt class="w-32 text-xs font-bold uppercase tracking-wide text-purple-400">Jatuh Tempo</dt>
                    <dd class="text-sm font-bold text-red-600">{{ \Carbon\Carbon::parse($penjualan->jatuh_tempo)->format('d F Y') }}</dd>
                </div>
                @endif
            </dl>
        </div>

        <div class="rounded-2xl bg-purple-50/50 p-4">
            <h6 class="text-xs font-bold uppercase tracking-wide text-purple-400 mb-2">Konsumen</h6>
            <div class="text-sm text-slate-700">
                <strong>{{ $penjualan->konsumen->nama }}</strong><br>
                {{ $penjualan->konsumen->alamat }}<br>
                Telp: {{ $penjualan->konsumen->telepon }}
            </div>
        </div>
    </div>

    {{-- Tabel Barang --}}
    <h6 class="text-sm font-semibold text-slate-700 mb-3">Daftar Barang Dibeli</h6>
    <div class="overflow-x-auto rounded-xl border border-purple-100">
        <table class="table-premium w-full text-left">
            <thead class="bg-purple-100">
                <tr>
                    <th>Kode</th>
                    <th>Judul Buku</th>
                    <th class="text-right">Harga Jual</th>
                    <th class="text-center">Qty</th>
                    <th class="text-right">Diskon</th>
                    <th class="text-right">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($penjualan->details as $detail)
                <tr class="border-t border-purple-50">
                    <td class="font-mono text-purple-600">{{ $detail->barang->kode }}</td>
                    <td class="text-slate-700">{{ $detail->barang->judul }}</td>
                    <td class="text-right text-slate-700">Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                    <td class="text-center text-slate-700">{{ $detail->qty }}</td>
                    <td class="text-right text-slate-700">Rp {{ number_format($detail->diskon, 0, ',', '.') }}</td>
                    <td class="text-right font-medium text-slate-800">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot class="bg-purple-50/50">
                <tr>
                    <td colspan="5" class="text-right font-bold text-purple-700">GRAND TOTAL:</td>
                    <td class="text-right font-bold text-red-700 text-lg">Rp {{ number_format($penjualan->total, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>
    </div>

    {{-- Tombol Aksi --}}
    <div class="mt-6 flex items-center gap-3 border-t border-purple-50 pt-5 no-print">
        <button onclick="window.print()" class="inline-flex items-center gap-2 rounded-lg bg-green-600 px-5 py-2.5 text-sm font-medium text-white hover:bg-green-700 transition">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 19.25h10.56M6.72 4.75h10.56a2.25 2.25 0 0 1 2.25 2.25v9.75a2.25 2.25 0 0 1-2.25 2.25H6.72a2.25 2.25 0 0 1-2.25-2.25V7a2.25 2.25 0 0 1 2.25-2.25Z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 10.75h4.5M9.75 14.75h4.5" />
            </svg>
            Cetak Struk Penjualan
        </button>
        <x-button as="a" href="{{ route('penjualan.index') }}" variant="ghost">Kembali</x-button>
    </div>
</x-card>
</div>
@endsection