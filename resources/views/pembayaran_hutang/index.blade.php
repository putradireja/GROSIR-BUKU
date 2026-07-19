@extends('layouts.app')

@section('title', 'Data Pembayaran Hutang')

@section('content')
<x-card title="Data Pembayaran Hutang" subtitle="Riwayat pembayaran hutang kepada pemasok">
    <x-slot name="actions">
        <x-button as="a" href="{{ route('pembayaran-hutang.create') }}" variant="primary">
            Bayar Hutang Baru
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
                    <th>No Bayar</th>
                    <th>Tanggal</th>
                    <th>Ref Pembelian</th>
                    <th>Supplier</th>
                    <th>Jumlah Dibayar</th>
                    <th>Sisa Hutang</th>
                    <th class="text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pembayarans as $p)
                <tr class="border-t border-purple-50">
                    <td class="font-semibold text-purple-600">{{ $p->no_bayar }}</td>
                    <td>{{ \Carbon\Carbon::parse($p->tgl_bayar)->format('d-m-Y') }}</td>
                    <td>
                        <a href="{{ route('pembelian.show', $p->pembelian_id) }}" class="text-purple-600 hover:text-purple-800 font-medium">
                            {{ $p->pembelian->no_beli }}
                        </a>
                    </td>
                    <td>{{ $p->supplier->nama }}</td>
                    <td class="font-bold text-purple-600">Rp {{ number_format($p->jumlah_bayar, 0, ',', '.') }}</td>
                    <td class="font-semibold">Rp {{ number_format($p->sisa_hutang, 0, ',', '.') }}</td>
                    <td>
                        <div class="flex items-center justify-end gap-2">
                            <x-button as="a" href="{{ route('pembayaran-hutang.show', $p->id) }}" variant="ghost">Bukti</x-button>
                            <form action="{{ route('pembayaran-hutang.destroy', $p->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin membatalkan pembayaran ini? Sisa hutang akan dikembalikan.')">
                                @csrf
                                @method('DELETE')
                                <x-button type="submit" variant="danger">Batal</x-button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                    <x-empty-state label="Belum ada riwayat pembayaran hutang." :colspan="7" />
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-5">
        {{ $pembayarans->links() }}
    </div>
</x-card>
@endsection