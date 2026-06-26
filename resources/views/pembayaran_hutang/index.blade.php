@extends('layouts.app')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Data Pembayaran Hutang (Ke Supplier)</h5>
        <a href="{{ route('pembayaran-hutang.create') }}" class="btn btn-light btn-sm">Bayar Hutang Baru</a>
    </div>
    <div class="card-body">
        @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
        @if(session('error')) <div class="alert alert-danger">{{ session('error') }}</div> @endif

        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>No Bayar</th>
                        <th>Tanggal</th>
                        <th>No Pembelian</th>
                        <th>Supplier</th>
                        <th>Jumlah Dibayar</th>
                        <th>Sisa Hutang</th>
                        <th width="160px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pembayarans as $p)
                    <tr>
                        <td>{{ $p->no_bayar }}</td>
                        <td>{{ \Carbon\Carbon::parse($p->tgl_bayar)->format('d-m-Y') }}</td>
                        <td>
                            <a href="{{ route('pembelian.show', $p->pembelian_id) }}" class="text-decoration-none fw-bold">
                                {{ $p->pembelian->no_beli }}
                            </a>
                        </td>
                        <td>{{ $p->supplier->nama }}</td>
                        <td class="text-primary fw-bold">Rp {{ number_format($p->jumlah_bayar, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($p->sisa_hutang, 0, ',', '.') }}</td>
                        <td>
                            <form action="{{ route('pembayaran-hutang.destroy', $p->id) }}" method="POST">
                                <a href="{{ route('pembayaran-hutang.show', $p->id) }}" class="btn btn-info btn-sm text-white">Bukti</a>
                                @csrf 
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin membatalkan pembayaran ini?')">Batal</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">Belum ada riwayat pembayaran hutang.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $pembayarans->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection