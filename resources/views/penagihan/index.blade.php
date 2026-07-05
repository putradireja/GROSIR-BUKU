@extends('layouts.app')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-warning text-dark d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Data Penagihan (Pembayaran Piutang)</h5>

        <div class="d-flex gap-2">
            <a href="{{ asset('dokumen/BUKU PANDUAN PENGGUNA.pdf') }}" target="_blank" class="btn btn-dark btn-sm me-2">
            <i class="fas fa-book"></i> Buku Panduan
            </a>
            <a href="{{ route('penagihan.create') }}" class="btn btn-dark btn-sm">Terima Pembayaran Baru</a>
        </div>
    </div>
    <div class="card-body">
        @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
        @if(session('error')) <div class="alert alert-danger">{{ session('error') }}</div> @endif

        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>No Tagih</th>
                        <th>Tanggal</th>
                        <th>No Penjualan</th>
                        <th>Konsumen</th>
                        <th>Jumlah Dibayar</th>
                        <th>Sisa Piutang</th>
                        <th width="160px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($penagihans as $p)
                    <tr>
                        <td>{{ $p->no_tagih }}</td>
                        <td>{{ \Carbon\Carbon::parse($p->tgl_tagih)->format('d-m-Y') }}</td>
                        <td>
                            <a href="{{ route('penjualan.show', $p->penjualan_id) }}" class="text-decoration-none fw-bold">
                                {{ $p->penjualan->no_jual }}
                            </a>
                        </td>
                        <td>{{ $p->konsumen->nama }}</td>
                        <td class="text-success fw-bold">Rp {{ number_format($p->jumlah_bayar, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($p->sisa_piutang, 0, ',', '.') }}</td>
                        <td>
                            <form action="{{ route('penagihan.destroy', $p->id) }}" method="POST">
                                <a href="{{ route('penagihan.show', $p->id) }}" class="btn btn-info btn-sm text-white">Bukti</a>
                                @csrf 
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin membatalkan pembayaran ini?')">Batal</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">Belum ada riwayat pembayaran piutang.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $penagihans->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection