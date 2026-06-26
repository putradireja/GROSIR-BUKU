@extends('layouts.app')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Form Pembayaran Hutang Supplier</h5>
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
        
        <form action="{{ route('pembayaran-hutang.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label>No. Bukti Bayar</label>
                    <input type="text" name="no_bayar" class="form-control" value="{{ $no_bayar }}" readonly>
                </div>
                <div class="col-md-4 mb-3">
                    <label>Tanggal Pembayaran</label>
                    <input type="date" name="tgl_bayar" class="form-control" value="{{ date('Y-m-d') }}" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label>Pilih Transaksi (Pembelian Credit)</label>
                    <select name="pembelian_id" id="select_pembelian" class="form-control" required>
                        <option value="">-- Pilih No Pembelian --</option>
                        @foreach($pembelians as $pb)
                            <option value="{{ $pb->id }}" 
                                    data-supplier-id="{{ $pb->supplier_id }}" 
                                    data-supplier-nama="{{ $pb->supplier->nama }}"
                                    data-sisa="{{ $pb->sisa_hutang }}">
                                {{ $pb->no_beli }} - {{ $pb->supplier->nama }} (Sisa: Rp {{ number_format($pb->sisa_hutang, 0, ',', '.') }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <input type="hidden" name="supplier_id" id="supplier_id">

                <div class="col-md-4 mb-3">
                    <label>Nama Supplier</label>
                    <input type="text" id="supplier_nama" class="form-control bg-light" readonly>
                </div>
                <div class="col-md-4 mb-3">
                    <label>Total Sisa Hutang Saat Ini (Rp)</label>
                    <input type="number" name="total_hutang" id="total_hutang" class="form-control bg-light" readonly required>
                </div>
                <div class="col-md-4 mb-3">
                    <label>Jumlah Bayar Keluar (Rp)</label>
                    <input type="number" name="jumlah_bayar" id="jumlah_bayar" class="form-control fw-bold text-primary" min="1" required>
                </div>
                
                <div class="col-md-12 mb-3">
                    <label>Keterangan / Catatan</label>
                    <textarea name="ket" class="form-control" rows="2" placeholder="Contoh: Pembayaran termin 1 / Lunas via Bank Mandiri"></textarea>
                </div>
            </div>

            <hr>
            <button type="submit" class="btn btn-primary">Proses Pembayaran</button>
            <a href="{{ route('pembayaran-hutang.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectPembelian = document.getElementById('select_pembelian');
    const inputSupplierId = document.getElementById('supplier_id');
    const inputSupplierNama = document.getElementById('supplier_nama');
    const inputTotalHutang = document.getElementById('total_hutang');
    const inputJumlahBayar = document.getElementById('jumlah_bayar');

    selectPembelian.addEventListener('change', function() {
        const selected = this.options[this.selectedIndex];
        
        if (this.value) {
            const sisa = selected.getAttribute('data-sisa');
            
            inputSupplierId.value = selected.getAttribute('data-supplier-id');
            inputSupplierNama.value = selected.getAttribute('data-supplier-nama');
            inputTotalHutang.value = sisa;
            
            inputJumlahBayar.setAttribute('max', sisa);
            inputJumlahBayar.value = sisa; // Default lunas
        } else {
            inputSupplierId.value = '';
            inputSupplierNama.value = '';
            inputTotalHutang.value = '';
            inputJumlahBayar.removeAttribute('max');
            inputJumlahBayar.value = '';
        }
    });
});
</script>
@endsection