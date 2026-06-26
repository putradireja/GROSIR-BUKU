@extends('layouts.app')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Data Barang (Buku)</h5>
        <a href="{{ route('master.barang.create') }}" class="btn btn-outline-light btn-sm">Tambah Barang</a>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Kode</th>
                        <th>Judul Buku</th>
                        <th>Kategori</th>
                        <th>Harga Beli</th>
                        <th>Harga Jual</th>
                        <th>Stok</th>
                        <th width="180px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($barangs as $barang)
                    <tr>
                        <td>{{ $loop->iteration + $barangs->firstItem() - 1 }}</td>
                        <td>{{ $barang->kode }}</td>
                        <td>{{ $barang->judul }}</td>
                        <td>{{ $barang->kategori }}</td>
                        <td>Rp {{ number_format($barang->harga_beli, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($barang->harga_jual, 0, ',', '.') }}</td>
                        <td>
                            <span class="badge {{ $barang->stok > 10 ? 'bg-success' : 'bg-danger' }}">
                                {{ $barang->stok }}
                            </span>
                        </td>
                        <td>
                            <form action="{{ route('master.barang.destroy', $barang->id) }}" method="POST">
                                <a href="{{ route('master.barang.show', $barang->id) }}" class="btn btn-info btn-sm text-white">Detail</a>
                                <a href="{{ route('master.barang.edit', $barang->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">Data Barang belum tersedia.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $barangs->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection