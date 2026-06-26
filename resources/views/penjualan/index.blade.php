@extends('layouts.app')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-danger text-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Transaksi Penjualan</h5>
        <a href="{{ route('penjualan.create') }}" class="btn btn-light btn-sm">Kasir (Penjualan Baru)</a>
    </div>
    <div class="card-body">
        @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
        @if(session('error')) <div class="alert alert-danger">{{ session('error') }}</div> @endif

        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>No Jual</th>
                        <th>Tanggal</th>
                        <th>Konsumen</th>
                        <th>Tipe</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th width="150px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($penjualans as $pj)
                    <tr>
                        <td>{{ $pj->no_jual }}</td>
                        <td>{{ \Carbon\Carbon::parse($pj->tgl_jual)->format('d-m-Y') }}</td>
                        <td>{{ $pj->konsumen->nama }}</td>
                        <td><span class="badge {{ $pj->tipe == 'cash' ? 'bg-primary' : 'bg-danger' }}">{{ strtoupper($pj->tipe) }}</span></td>
                        <td>Rp {{ number_format($pj->total, 0, ',', '.') }}</td>
                        <td>
                            @if($pj->status_bayar == 'lunas') <span class="badge bg-success">Lunas</span>
                            @else <span class="badge bg-warning text-dark">Belum Lunas</span> @endif
                        </td>
                        <td>
                            <form action="{{ route('penjualan.destroy', $pj->id) }}" method="POST">
                                <a href="{{ route('penjualan.show', $pj->id) }}" class="btn btn-info btn-sm text-white">Detail</a>
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus transaksi ini? Stok barang akan dikembalikan ke awal.')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="text-center">Belum ada transaksi penjualan.</td></tr>
                    @endforelse
                </tbody>
            </table>
            {{ $penjualans->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection