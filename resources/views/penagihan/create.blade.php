@extends('layouts.app')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-warning text-dark">
        <h5 class="mb-0">Form Terima Pembayaran Piutang</h5>
    </div>
    <div class="card-body">
        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Gagal Menyimpan!</strong> Periksa kembali isian Anda:
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if(session('error')) <div class="alert alert-danger">{{ session('error') }}</div> @endif
        
        <form action="{{ route('penagihan.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label>No. Tanda Terima</label>
                    <input type="text" name="no_tagih" class="form-control" value="{{ $no_tagih }}" readonly>
                </div>
                <div class="col-md-4 mb-3">
                    <label>Tanggal Pembayaran</label>
                    <input type="date" name="tgl_tagih" class="form-control" value="{{ date('Y-m-d') }}" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label>Pilih Transaksi (Penjualan Credit)</label>
                    <select name="penjualan_id" id="select_penjualan" class="form-control" required>
                        <option value="">-- Pilih No Penjualan --</option>
                        @foreach($penjualans as $pj)
                            <option value="{{ $pj->id }}" 
                                    data-konsumen-id="{{ $pj->konsumen_id }}" 
                                    data-konsumen-nama="{{ $pj->konsumen->nama }}"
                                    data-sisa="{{ $pj->sisa_piutang }}">
                                {{ $pj->no_jual }} - {{ $pj->konsumen->nama }} (Sisa: Rp {{ number_format($pj->sisa_piutang, 0, ',', '.') }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <input type="hidden" name="konsumen_id" id="konsumen_id">

                <div class="col-md-4 mb-3">
                    <label>Nama Konsumen</label>
                    <input type="text" id="konsumen_nama" class="form-control bg-light" readonly>
                </div>
                <div class="col-md-4 mb-3">
                    <label>Total Sisa Piutang Saat Ini (Rp)</label>
                    <input type="number" name="total_piutang" id="total_piutang" class="form-control bg-light" readonly required>
                </div>
                <div class="col-md-4 mb-3">
                    <label>Jumlah Bayar Diterima (Rp)</label>
                    <input type="number" name="jumlah_bayar" id="jumlah_bayar" class="form-control fw-bold text-success" min="1" required>
                </div>
                
                <div class="col-md-12 mb-3">
                    <label>Keterangan / Catatan</label>
                    <textarea name="ket" class="form-control" rows="2" placeholder="Contoh: Pembayaran cicilan ke-1 / Lunas Transfer BCA"></textarea>
                </div>
            </div>

            <hr>
            <button type="submit" class="btn btn-primary">Simpan Pembayaran</button>
            <a href="{{ route('penagihan.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectPenjualan = document.getElementById('select_penjualan');
    const inputKonsumenId = document.getElementById('konsumen_id');
    const inputKonsumenNama = document.getElementById('konsumen_nama');
    const inputTotalPiutang = document.getElementById('total_piutang');
    const inputJumlahBayar = document.getElementById('jumlah_bayar');

    selectPenjualan.addEventListener('change', function() {
        const selected = this.options[this.selectedIndex];
        
        if (this.value) {
            const sisa = selected.getAttribute('data-sisa');
            
            inputKonsumenId.value = selected.getAttribute('data-konsumen-id');
            inputKonsumenNama.value = selected.getAttribute('data-konsumen-nama');
            inputTotalPiutang.value = sisa;
            
            // Set max atribut untuk mencegah input angka melebihi hutang
            inputJumlahBayar.setAttribute('max', sisa);
            inputJumlahBayar.value = sisa; // Default langsung auto lunas
        } else {
            inputKonsumenId.value = '';
            inputKonsumenNama.value = '';
            inputTotalPiutang.value = '';
            inputJumlahBayar.removeAttribute('max');
            inputJumlahBayar.value = '';
        }
    });
});
</script>
@endsection