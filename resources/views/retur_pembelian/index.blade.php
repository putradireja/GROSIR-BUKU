@extends('layouts.app')

@section('title', 'Data Retur Pembelian')

@section('content')
<x-card title="Data Retur Pembelian" subtitle="Daftar pengembalian barang ke supplier">
    <x-slot name="actions">
        <x-button as="a" href="{{ route('retur-pembelian.create') }}" variant="primary">
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
                    <th>Ref Pembelian</th>
                    <th>Supplier</th>
                    <th>Keterangan</th>
                    <th class="text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($returs as $r)
                <tr class="border-t border-purple-50">
                    <td class="font-semibold text-purple-600">{{ $r->no_retur }}</td>
                    <td>{{ \Carbon\Carbon::parse($r->tgl_retur)->format('d-m-Y') }}</td>
                    <td>
                        <a href="{{ route('pembelian.show', $r->pembelian_id) }}" class="text-purple-600 hover:text-purple-800">
                            {{ $r->pembelian->no_beli }}
                        </a>
                    </td>
                    <td class="font-medium text-slate-700">{{ $r->supplier->nama }}</td>
                    <td class="text-slate-600">{{ $r->keterangan ?? '-' }}</td>
                    <td>
                        <div class="flex items-center justify-end gap-2">
                            <x-button as="a" href="{{ route('retur-pembelian.show', $r->id) }}" variant="ghost">Detail</x-button>
                            <form action="{{ route('retur-pembelian.destroy', $r->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin membatalkan retur ini? Stok akan dikembalikan ke gudang.')">
                                @csrf
                                @method('DELETE')
                                <x-button type="submit" variant="danger">Batal</x-button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                    <x-empty-state label="Belum ada data retur pembelian." :colspan="6" />
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-5">
        {{ $returs->links() }}
    </div>
</x-card>
@endsection