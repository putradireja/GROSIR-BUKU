@extends('layouts.app')

@section('title', 'Data Retur Penjualan')

@section('content')
<x-card title="Data Retur Penjualan" subtitle="Daftar pengembalian barang dari konsumen">
    <x-slot name="actions">
        <x-button as="a" href="{{ route('retur-penjualan.create') }}" variant="primary">
            Buat Retur Baru
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
                    <th>No Retur</th>
                    <th>Tanggal</th>
                    <th>Ref Penjualan</th>
                    <th>Konsumen</th>
                    <th>Alasan</th>
                    <th class="text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($returs as $r)
                <tr class="border-t border-purple-50">
                    <td class="font-semibold text-purple-600">{{ $r->no_retur }}</td>
                    <td>{{ \Carbon\Carbon::parse($r->tgl_retur)->format('d-m-Y') }}</td>
                    <td>
                        <a href="{{ route('penjualan.show', $r->penjualan_id) }}" class="text-purple-600 hover:text-purple-800">
                            {{ $r->penjualan->no_jual }}
                        </a>
                    </td>
                    <td class="font-medium text-slate-700">{{ $r->konsumen->nama ?? 'Tanpa Konsumen' }}</td>
                    <td class="text-slate-600">{{ $r->alasan ?? '-' }}</td>
                    <td>
                        <div class="flex items-center justify-end gap-2">
                            <x-button as="a" href="{{ route('retur-penjualan.show', $r->id) }}" variant="ghost">Detail</x-button>
                            <form action="{{ route('retur-penjualan.destroy', $r->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin membatalkan retur ini? Stok akan dikurangi kembali.')">
                                @csrf
                                @method('DELETE')
                                <x-button type="submit" variant="danger">Batal</x-button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                    <x-empty-state label="Belum ada data retur penjualan." :colspan="6" />
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-5">
        {{ $returs->links() }}
    </div>
</x-card>
@endsection