@extends('layouts.app')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Data Supplier</h5>
        <a href="{{ route('master.supplier.create') }}" class="btn btn-light btn-sm">Tambah Supplier</a>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Telepon</th>
                        <th>Email</th>
                        <th width="200px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($suppliers as $supplier)
                    <tr>
                        <td>{{ $loop->iteration + $suppliers->firstItem() - 1 }}</td>
                        <td>{{ $supplier->kode }}</td>
                        <td>{{ $supplier->nama }}</td>
                        <td>{{ $supplier->telepon }}</td>
                        <td>{{ $supplier->email }}</td>
                        <td>
                            <form action="{{ route('master.supplier.destroy', $supplier->id) }}" method="POST">
                                <a href="{{ route('master.supplier.show', $supplier->id) }}" class="btn btn-info btn-sm text-white">Detail</a>
                                <a href="{{ route('master.supplier.edit', $supplier->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">Data Supplier belum tersedia.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $suppliers->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection