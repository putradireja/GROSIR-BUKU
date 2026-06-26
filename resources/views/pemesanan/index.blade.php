@extends('layouts.app')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Data Pemesanan (PO)</h5>
        <a href="{{ route('pemesanan.create') }}" class="btn btn-light btn-sm">Buat Pemesanan Baru</a>
    </div>
    <div class="card-body">
        @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
        @if(session('error')) <div class="alert alert-danger">{{ session('error') }}</div> @endif

        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>No Pesan</th>
                        <th>Tanggal</th>
                        <th>Supplier</th>
                        <th>Status</th>
                        <th width="250px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pemesanans as $po)
                    <tr>
                        <td>{{ $po->no_pesan }}</td>
                        <td>{{ \Carbon\Carbon::parse($po->tgl_pesan)->format('d-m-Y') }}</td>
                        <td>{{ $po->supplier->nama }}</td>
                        <td>
                            @if($po->status == 'pending') <span class="badge bg-warning text-dark">Pending</span>
                            @elseif($po->status == 'approved') <span class="badge bg-success">Approved</span>
                            @else <span class="badge bg-danger">Cancelled</span> @endif
                        </td>
                        <td>
                            <a href="{{ route('pemesanan.show', $po->id) }}" class="btn btn-info btn-sm text-white">Detail</a>
                            
                            @if($po->status == 'pending')
                                <form action="{{ route('pemesanan.approve', $po->id) }}" method="POST" class="d-inline">
                                    @csrf <button class="btn btn-success btn-sm">Setujui</button>
                                </form>
                                <form action="{{ route('pemesanan.cancel', $po->id) }}" method="POST" class="d-inline">
                                    @csrf <button class="btn btn-secondary btn-sm" onclick="return confirm('Batalkan pesanan?')">Batal</button>
                                </form>
                                <form action="{{ route('pemesanan.destroy', $po->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger btn-sm" onclick="return confirm('Hapus pesanan ini?')">Hapus</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center">Belum ada data pemesanan.</td></tr>
                    @endforelse
                </tbody>
            </table>
            {{ $pemesanans->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection