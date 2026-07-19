@extends('layouts.app')

@section('title', 'Data Pemesanan (PO)')

@section('content')
<x-card title="Data Pemesanan (PO)" subtitle="Daftar pesanan barang ke supplier">
    <x-slot name="actions">
        <x-button as="a" href="{{ route('pemesanan.create') }}" variant="primary">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            Buat Pemesanan Baru
        </x-button>
    </x-slot>

    <div class="overflow-x-auto rounded-2xl border border-purple-50">
        <table class="table-premium w-full text-left">
            <thead>
                <tr>
                    <th>No. Pesan</th>
                    <th>Tanggal</th>
                    <th>Supplier</th>
                    <th>Status</th>
                    <th class="text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pemesanans as $po)
                <tr>
                    <td class="font-semibold text-purple-600">{{ $po->no_pesan }}</td>
                    <td>{{ \Carbon\Carbon::parse($po->tgl_pesan)->format('d-m-Y') }}</td>
                    <td class="font-medium text-slate-700">{{ $po->supplier->nama }}</td>
                    <td>
                        @if($po->status == 'pending')
                            <x-badge color="warning">Pending</x-badge>
                        @elseif($po->status == 'approved')
                            <x-badge color="success">Approved</x-badge>
                        @else
                            <x-badge color="danger">Cancelled</x-badge>
                        @endif
                    </td>
                    <td>
                        <div class="flex items-center justify-end gap-2">
                            <x-button as="a" href="{{ route('pemesanan.show', $po->id) }}" variant="ghost">Detail</x-button>

                            @if($po->status == 'pending')
                                <form action="{{ route('pemesanan.approve', $po->id) }}" method="POST" class="inline">
                                    @csrf
                                    <x-button type="submit" variant="success">Setujui</x-button>
                                </form>
                                <form action="{{ route('pemesanan.cancel', $po->id) }}" method="POST" class="inline">
                                    @csrf
                                    <x-button type="submit" variant="secondary" onclick="return confirm('Batalkan pesanan?')">Batal</x-button>
                                </form>
                                <form action="{{ route('pemesanan.destroy', $po->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <x-button type="submit" variant="danger" onclick="return confirm('Hapus pesanan ini?')">Hapus</x-button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                    <x-empty-state label="Belum ada data pemesanan." :colspan="5" />
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-5">
        {{ $pemesanans->links() }}
    </div>
</x-card>
@endsection