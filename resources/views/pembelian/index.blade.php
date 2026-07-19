@extends('layouts.app')

@section('title', 'Transaksi Pembelian')

@section('content')
<x-card title="Transaksi Pembelian (Barang Masuk)" subtitle="Daftar seluruh transaksi penerimaan barang">
    <x-slot name="actions">
        <x-button as="a" href="{{ route('pembelian.create') }}" variant="primary">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            Buat Pembelian Baru
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
                    <th>No Beli</th>
                    <th>Tanggal</th>
                    <th>Supplier</th>
                    <th>Tipe</th>
                    <th>Total</th>
                    <th>Status Bayar</th>
                    <th class="text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pembelians as $pb)
                <tr>
                    <td class="font-semibold text-purple-600">{{ $pb->no_beli }}</td>
                    <td>{{ \Carbon\Carbon::parse($pb->tgl_beli)->format('d-m-Y') }}</td>
                    <td class="font-medium text-slate-700">{{ $pb->supplier->nama }}</td>
                    <td>
                        <x-badge :color="$pb->tipe == 'cash' ? 'blue' : 'red'">
                            {{ strtoupper($pb->tipe) }}
                        </x-badge>
                    </td>
                    <td>Rp {{ number_format($pb->total, 0, ',', '.') }}</td>
                    <td>
                        @if($pb->status_bayar == 'lunas')
                            <x-badge color="green">Lunas</x-badge>
                        @else
                            <x-badge color="warning">Belum Lunas</x-badge>
                        @endif
                    </td>
                    <td>
                        <div class="flex items-center justify-end gap-2">
                            <x-button as="a" href="{{ route('pembelian.show', $pb->id) }}" variant="ghost">Detail</x-button>
                            <form action="{{ route('pembelian.destroy', $pb->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus transaksi ini? Stok barang akan dikurangi kembali.')">
                                @csrf
                                @method('DELETE')
                                <x-button type="submit" variant="danger">Hapus</x-button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                    <x-empty-state label="Belum ada transaksi pembelian." :colspan="7" />
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-5">
        {{ $pembelians->links() }}
    </div>
</x-card>
@endsection