@extends('layouts.app')

@section('title', 'Daftar Transaksi Penjualan')

@section('content')
<x-card title="Transaksi Penjualan" subtitle="Daftar seluruh riwayat penjualan barang">
    <x-slot name="actions">
        <x-button as="a" href="{{ route('penjualan.create') }}" variant="primary">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            Penjualan Baru
        </x-button>
    </x-slot>

    @if(session('success'))
        <div class="mb-4 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
            {{ session('error') }}
        </div>
    @endif

    <div class="overflow-x-auto rounded-2xl border border-purple-50">
        <table class="table-premium w-full text-left">
            <thead>
                <tr>
                    <th>No Jual</th>
                    <th>Tanggal</th>
                    <th>Konsumen</th>
                    <th>Tipe</th>
                    <th>Total</th>
                    <th>Status Bayar</th>
                    <th class="text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($penjualans as $pj)
                <tr>
                    <td class="font-semibold text-purple-600">{{ $pj->no_jual }}</td>
                    <td>{{ \Carbon\Carbon::parse($pj->tgl_jual)->format('d-m-Y') }}</td>
                    <td class="font-medium text-slate-700">{{ $pj->konsumen->nama }}</td>
                    <td>
                        <x-badge :color="$pj->tipe == 'cash' ? 'blue' : 'red'">
                            {{ strtoupper($pj->tipe) }}
                        </x-badge>
                    </td>
                    <td>Rp {{ number_format($pj->total, 0, ',', '.') }}</td>
                    <td>
                        @if($pj->status_bayar == 'lunas')
                            <x-badge color="green">Lunas</x-badge>
                        @else
                            <x-badge color="warning">Belum Lunas</x-badge>
                        @endif
                    </td>
                    <td>
                        <div class="flex items-center justify-end gap-2">
                            <x-button as="a" href="{{ route('penjualan.show', $pj->id) }}" variant="ghost">Detail</x-button>
                            <form action="{{ route('penjualan.destroy', $pj->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus transaksi ini? Stok barang akan dikembalikan ke awal.')">
                                @csrf
                                @method('DELETE')
                                <x-button type="submit" variant="danger">Hapus</x-button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                    <x-empty-state label="Belum ada transaksi penjualan." :colspan="7" />
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-5">
        {{ $penjualans->links() }}
    </div>
</x-card>
@endsection