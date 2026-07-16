@extends('layouts.app')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Data Retur Penjualan</h5>
        <a href="{{ route('retur-penjualan.create') }}" class="btn btn-light btn-sm">Buat Retur Baru</a>
    </div>
    <div class="card-body">
        @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
        @if(session('error')) <div class="alert alert-danger">{{ session('error') }}</div> @endif

        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>No Retur</th>
                        <th>Tanggal</th>
                        <th>Ref Penjualan</th>
                        <th>Konsumen</th>
                        <th>Alasan</th>
                        <th width="160px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($returs as $r)
                    <tr>
                        <td>{{ $r->no_retur }}</td>
                        <td>{{ \Carbon\Carbon::parse($r->tgl_retur)->format('d-m-Y') }}</td>
                        <td><a href="{{ route('penjualan.show', $r->penjualan_id) }}">{{ $r->penjualan->no_jual }}</a></td>
                        <td>{{ $r->konsumen->nama ?? 'Tanpa Konsumen' }}</td>
                        <td>{{ $r->alasan ?? '-' }}</td>
                        <td>
                            <form action="{{ route('retur-penjualan.destroy', $r->id) }}" method="POST">
                                <a href="{{ route('retur-penjualan.show', $r->id) }}" class="btn btn-info btn-sm text-white">Detail</a>
                                @csrf 
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin membatalkan retur ini? Stok akan dikembalikan ke gudang.')">Batal</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">Belum ada data retur penjualan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $returs->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection