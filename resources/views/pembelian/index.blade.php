@extends('layouts.app')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Transaksi Pembelian (Barang Masuk)</h5>
        <a href="{{ route('pembelian.create') }}" class="btn btn-light btn-sm">Buat Pembelian Baru</a>
    </div>
    <div class="card-body">
        @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
        @if(session('error')) <div class="alert alert-danger">{{ session('error') }}</div> @endif

        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>No Beli</th>
                        <th>Tanggal</th>
                        <th>Supplier</th>
                        <th>Tipe</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th width="150px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pembelians as $pb)
                    <tr>
                        <td>{{ $pb->no_beli }}</td>
                        <td>{{ \Carbon\Carbon::parse($pb->tgl_beli)->format('d-m-Y') }}</td>
                        <td>{{ $pb->supplier->nama }}</td>
                        <td><span class="badge {{ $pb->tipe == 'cash' ? 'bg-primary' : 'bg-danger' }}">{{ strtoupper($pb->tipe) }}</span></td>
                        <td>Rp {{ number_format($pb->total, 0, ',', '.') }}</td>
                        <td>
                            @if($pb->status_bayar == 'lunas') <span class="badge bg-success">Lunas</span>
                            @else <span class="badge bg-warning text-dark">Belum Lunas</span> @endif
                        </td>
                        <td>
                            <form action="{{ route('pembelian.destroy', $pb->id) }}" method="POST">
                                <a href="{{ route('pembelian.show', $pb->id) }}" class="btn btn-info btn-sm text-white">Detail</a>
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus transaksi ini? Stok barang akan dikurangi kembali.')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="text-center">Belum ada transaksi pembelian.</td></tr>
                    @endforelse
                </tbody>
            </table>
            {{ $pembelians->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection