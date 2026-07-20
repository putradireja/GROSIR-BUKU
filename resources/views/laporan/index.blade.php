@extends('layouts.app')

@section('content')
<div class="mb-6">
    <p class="text-xs font-medium text-slate-400">
        <a href="{{ route('dashboard') }}" class="hover:text-indigo-600">Dashboard</a> / Laporan
    </p>
    <h1 class="mt-1 text-2xl font-bold text-slate-800">Laporan</h1>
</div>

@php
    $groups = [
        'Master Data' => [
            'barang'   => ['Stok Barang', 'Ringkasan data dan stok barang'],
            'supplier' => ['Supplier', 'Daftar seluruh data supplier'],
            'konsumen' => ['Konsumen', 'Daftar seluruh data konsumen'],
        ],
        'Transaksi' => [
            'pemesanan' => ['Pemesanan', 'Riwayat pemesanan ke supplier'],
            'pembelian' => ['Pembelian', 'Riwayat pembelian barang'],
            'penjualan' => ['Penjualan', 'Riwayat penjualan ke konsumen'],
        ],
        'Retur' => [
            'retur-pembelian' => ['Retur Pembelian', 'Barang yang diretur ke supplier'],
            'retur-penjualan' => ['Retur Penjualan', 'Barang yang diretur dari konsumen'],
        ],
        'Keuangan' => [
            'penagihan' => ['Penagihan', 'Riwayat tagihan ke konsumen'],
            'hutang'    => ['Pembayaran Hutang', 'Riwayat pembayaran hutang ke supplier'],
        ],
    ];
@endphp

<div class="flex flex-col gap-6">
    @foreach($groups as $groupName => $items)
    <div class="rounded-2xl bg-white p-6 shadow-sm">
        <h2 class="mb-4 text-sm font-bold uppercase tracking-wider text-slate-400">{{ $groupName }}</h2>

        <table class="w-full text-left">
            <tbody>
                @foreach($items as $key => $item)
                <tr class="border-b border-slate-50 last:border-0">
                    <td class="py-4 pr-4">
                        <p class="text-sm font-semibold text-slate-700">{{ $item[0] }}</p>
                        <p class="text-xs text-slate-400">{{ $item[1] }}</p>
                    </td>
                    <td class="py-4 pr-4">
                        <div class="flex justify-end gap-2">
                            <form action="{{ route('laporan.cetak') }}" method="POST">
                                @csrf
                                <input type="hidden" name="jenis" value="{{ $key }}">
                                <button type="submit" class="rounded-lg bg-indigo-600 px-3 py-1.5 text-xs font-semibold text-white hover:bg-indigo-700">
                                    Lihat
                                </button>
                            </form>
                            <a href="{{ route('laporan.export.pdf', $key) }}"
                               class="rounded-lg border border-rose-200 bg-rose-50 px-3 py-1.5 text-xs font-semibold text-rose-600 hover:bg-rose-100">
                                PDF
                            </a>
                            <a href="{{ route('laporan.export.excel', $key) }}"
                               class="rounded-lg border border-emerald-200 bg-emerald-50 px-3 py-1.5 text-xs font-semibold text-emerald-600 hover:bg-emerald-100">
                                Excel
                            </a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endforeach
</div>
@endsection