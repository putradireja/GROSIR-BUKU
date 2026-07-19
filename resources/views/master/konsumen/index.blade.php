@extends('layouts.app')

@section('title', 'Master Konsumen')

@section('content')
<x-card title="Data Konsumen" subtitle="Kelola seluruh data pelanggan toko">
    <x-slot name="actions">
        <x-button as="a" href="{{ route('master.konsumen.create') }}" variant="primary">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            Tambah Konsumen
        </x-button>
    </x-slot>

    <div class="overflow-x-auto rounded-2xl border border-purple-50">
        <table class="table-premium w-full text-left">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>Telepon</th>
                    <th>Email</th>
                    <th class="text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($konsumens as $konsumen)
                <tr>
                    <td>{{ $loop->iteration + $konsumens->firstItem() - 1 }}</td>
                    <td class="font-semibold text-purple-600">{{ $konsumen->kode }}</td>
                    <td class="font-medium text-slate-700">{{ $konsumen->nama }}</td>
                    <td>{{ $konsumen->telepon }}</td>
                    <td>{{ $konsumen->email }}</td>
                    <td>
                        <div class="flex items-center justify-end gap-2">
                            <x-button as="a" href="{{ route('master.konsumen.show', $konsumen->id) }}" variant="ghost">Detail</x-button>
                            <x-button as="a" href="{{ route('master.konsumen.edit', $konsumen->id) }}" variant="secondary">Edit</x-button>
                            <form action="{{ route('master.konsumen.destroy', $konsumen->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <x-button type="submit" variant="danger">Hapus</x-button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                    <x-empty-state label="Data Konsumen belum tersedia." :colspan="6" />
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-5">
        {{ $konsumens->links() }}
    </div>
</x-card>
@endsection