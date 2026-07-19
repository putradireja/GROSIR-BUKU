@extends('layouts.app')

@section('title', 'Detail Retur Pembelian')

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
<x-card title="Detail Retur Pembelian" subtitle="Informasi lengkap pengembalian barang">
    {{-- Info Utama & Supplier --}}
    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 mb-6">
        <div class="rounded-2xl bg-purple-50/50 p-4">
            <dl class="space-y-2">
                <div class="flex items-center gap-3">
                    <dt class="w-32 text-xs font-bold uppercase tracking-wide text-purple-400">No. Retur</dt>
                    <dd class="text-sm font-semibold text-slate-700">{{ $retur->no_retur }}</dd>
                </div>
                <div class="flex items-center gap-3">
                    <dt class="w-32 text-xs font-bold uppercase tracking-wide text-purple-400">Tanggal</dt>
                    <dd class="text-sm text-slate-700">{{ \Carbon\Carbon::parse($retur->tgl_retur)->format('d F Y') }}</dd>
                </div>
                <div class="flex items-center gap-3">
                    <dt class="w-32 text-xs font-bold uppercase tracking-wide text-purple-400">Ref Pembelian</dt>
                    <dd class="text-sm text-slate-700">
                        <a href="{{ route('pembelian.show', $retur->pembelian_id) }}" class="no-print text-purple-600 hover:text-purple-800">
                            {{ $retur->pembelian->no_beli }}
                        </a>
                        <span class="d-none d-print-inline">{{ $retur->pembelian->no_beli }}</span>
                    </dd>
                </div>
                <div class="flex items-center gap-3">
                    <dt class="w-32 text-xs font-bold uppercase tracking-wide text-purple-400">Keterangan</dt>
                    <dd class="text-sm font-medium text-red-600">{{ $retur->keterangan ?? '-' }}</dd>
                </div>
            </dl>
        </div>

        <div class="rounded-2xl bg-purple-50/50 p-4">
            <h6 class="text-xs font-bold uppercase tracking-wide text-purple-400 mb-2">Dikembalikan Kepada (Supplier)</h6>
            <div class="text-sm text-slate-700">
                <strong>{{ $retur->supplier->nama }}</strong><br>
                {{ $retur->supplier->alamat }}<br>
                Telp: {{ $retur->supplier->telepon }}
            </div>
        </div>
    </div>

    {{-- Tabel Barang --}}
    <h6 class="text-sm font-semibold text-slate-700 mb-3">Daftar Barang Dikembalikan</h6>
    <div class="overflow-x-auto rounded-xl border border-purple-100">
        <table class="table-premium w-full text-left">
            <thead class="bg-purple-100">
                <tr>
                    <th class="w-[10%] text-center">No</th>
                    <th class="w-[25%]">Kode Barang</th>
                    <th class="w-[45%]">Judul Buku</th>
                    <th class="w-[20%] text-center">Qty Diretur</th>
                </tr>
            </thead>
            <tbody>
                @foreach($retur->details as $detail)
                <tr class="border-t border-purple-50">
                    <td class="text-center text-slate-700">{{ $loop->iteration }}</td>
                    <td class="font-mono text-purple-600">{{ $detail->barang->kode }}</td>
                    <td class="text-slate-700">{{ $detail->barang->judul }}</td>
                    <td class="text-center">
                        <x-badge color="red">{{ $detail->qty }} Item</x-badge>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Tombol Aksi --}}
    <div class="mt-6 flex items-center gap-3 border-t border-purple-50 pt-5 no-print">
        <button onclick="window.print()" class="inline-flex items-center gap-2 rounded-lg bg-gray-600 px-5 py-2.5 text-sm font-medium text-white hover:bg-gray-700 transition">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 19.25h10.56M6.72 4.75h10.56a2.25 2.25 0 0 1 2.25 2.25v9.75a2.25 2.25 0 0 1-2.25 2.25H6.72a2.25 2.25 0 0 1-2.25-2.25V7a2.25 2.25 0 0 1 2.25-2.25Z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 10.75h4.5M9.75 14.75h4.5" />
            </svg>
            Cetak Surat Jalan Retur
        </button>
        <x-button as="a" href="{{ route('retur-pembelian.index') }}" variant="ghost">Kembali</x-button>
    </div>
</x-card>
</div>
@endsection