@extends('layouts.app')

@section('title', 'Master Barang')

@section('content')
<x-card title="Data Barang (Buku)" subtitle="Kelola seluruh koleksi buku yang tersedia">
    <x-slot name="actions">
        <x-button as="a" href="{{ route('master.barang.create') }}" variant="primary">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            Tambah Barang
        </x-button>
    </x-slot>

    <div class="overflow-x-auto rounded-2xl border border-purple-50">
        <table class="table-premium w-full text-left">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode</th>
                    <th>Judul Buku</th>
                    <th>Kategori</th>
                    <th>Harga Beli</th>
                    <th>Harga Jual</th>
                    <th>Stok</th>
                    <th class="text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($barangs as $barang)
                <tr>
                    <td>{{ $loop->iteration + $barangs->firstItem() - 1 }}</td>
                    <td class="font-semibold text-purple-600">{{ $barang->kode }}</td>
                    <td class="font-medium text-slate-700">{{ $barang->judul }}</td>
                    <td><x-badge color="purple">{{ $barang->kategori }}</x-badge></td>
                    <td>Rp {{ number_format($barang->harga_beli, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($barang->harga_jual, 0, ',', '.') }}</td>
                    <td>
                        <x-badge :color="$barang->stok > 10 ? 'green' : 'red'">
                            {{ $barang->stok }} pcs
                        </x-badge>
                    </td>
                    <td>
                        <div class="flex items-center justify-end gap-2">
                            <x-button as="a" href="{{ route('master.barang.show', $barang->id) }}" variant="ghost">Detail</x-button>
                            <x-button as="a" href="{{ route('master.barang.edit', $barang->id) }}" variant="secondary">Edit</x-button>
                            <form action="{{ route('master.barang.destroy', $barang->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <x-button type="submit" variant="danger">Hapus</x-button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                    <x-empty-state label="Data Barang belum tersedia." :colspan="8" />
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-5">
        {{ $barangs->links() }}
    </div>
</x-card>
@endsection