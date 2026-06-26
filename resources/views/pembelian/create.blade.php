@extends('layouts.app')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-success text-white">
        <h5 class="mb-0">Transaksi Pembelian Barang Masuk</h5>
    </div>
    <div class="card-body">
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
        @if(session('error')) 
            <div class="alert alert-danger">{{ session('error') }}</div> 
        @endif
        <form action="{{ route('pembelian.store') }}" method="POST">
        <form action="{{ route('pembelian.store') }}" method="POST">
            @csrf
            <div class="row mb-4">
                <div class="col-md-3 mb-3">
                    <label>No. Pembelian</label>
                    <input type="text" name="no_beli" class="form-control" value="{{ $no_beli }}" readonly>
                </div>
                <div class="col-md-3 mb-3">
                    <label>Tanggal Masuk</label>
                    <input type="date" name="tgl_beli" class="form-control" value="{{ date('Y-m-d') }}" required>
                </div>
                <div class="col-md-3 mb-3">
                    <label>Supplier</label>
                    <select name="supplier_id" class="form-control" required>
                        <option value="">-- Pilih Supplier --</option>
                        @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->id }}">{{ $supplier->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label>Ref.Pemesanan (PO)-Opsional</label>
                    <select name="pemesanan_id" class="form-control">
                        <option value="">-- Tanpa PO --</option>
                        @foreach($pemesanans as $po)
                            <option value="{{ $po->id }}">{{ $po->no_pesan }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-md-3 mb-3">
                    <label>Tipe Pembayaran</label>
                    <select name="tipe" id="tipe_bayar" class="form-control" required>
                        <option value="cash">CASH (Tunai)</option>
                        <option value="credit">CREDIT (Hutang)</option>
                    </select>
                </div>
                <div class="col-md-3 mb-3 d-none" id="div_jatuh_tempo">
                    <label>Tanggal Jatuh Tempo</label>
                    <input type="date" name="jatuh_tempo" id="jatuh_tempo" class="form-control">
                </div>
            </div>

            <h5 class="border-bottom pb-2">Detail Barang Masuk</h5>
            <table class="table table-bordered" id="table-detail">
                <thead class="table-light">
                    <tr>
                        <th>Pilih Barang</th>
                        <th width="180px">Harga Beli Satuan (Rp)</th>
                        <th width="120px">Qty (Masuk)</th>
                        <th width="180px">Subtotal (Rp)</th>
                        <th width="80px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <select name="barang_id[]" class="form-control select-barang" required>
                                <option value="">-- Pilih Barang --</option>
                                @foreach($barangs as $barang)
                                    <option value="{{ $barang->id }}" data-harga="{{ $barang->harga_beli }}">
                                        {{ $barang->kode }} - {{ $barang->judul }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td><input type="number" name="harga_satuan[]" class="form-control input-harga" required></td>
                        <td><input type="number" name="qty[]" class="form-control input-qty" value="1" min="1" required></td>
                        <td><input type="text" class="form-control input-subtotal" readonly></td>
                        <td><button type="button" class="btn btn-danger btn-sm btn-hapus">X</button></td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-end"><strong>GRAND TOTAL:</strong></td>
                        <td colspan="2"><input type="text" id="grand_total" class="form-control fw-bold text-success" readonly></td>
                    </tr>
                </tfoot>
            </table>
            <button type="button" class="btn btn-primary btn-sm mb-4" id="btn-tambah">+ Tambah Baris Barang</button>

            <hr>
            <button type="submit" class="btn btn-success">Simpan & Proses Barang Masuk</button>
            <a href="{{ route('pembelian.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tableBody = document.querySelector('#table-detail tbody');
    const grandTotalInput = document.getElementById('grand_total');
    
    // Logika menampilkan input jatuh tempo jika tipe pembayaran = credit
    document.getElementById('tipe_bayar').addEventListener('change', function() {
        const divTempo = document.getElementById('div_jatuh_tempo');
        const inputTempo = document.getElementById('jatuh_tempo');
        if(this.value === 'credit') {
            divTempo.classList.remove('d-none');
            inputTempo.setAttribute('required', 'true');
        } else {
            divTempo.classList.add('d-none');
            inputTempo.removeAttribute('required');
            inputTempo.value = '';
        }
    });

    // Logika menghitung Grand Total dan Subtotal
    function calculateTotal() {
        let grandTotal = 0;
        tableBody.querySelectorAll('tr').forEach(row => {
            const harga = parseFloat(row.querySelector('.input-harga').value) || 0;
            const qty = parseFloat(row.querySelector('.input-qty').value) || 0;
            const subtotal = harga * qty;
            row.querySelector('.input-subtotal').value = subtotal;
            grandTotal += subtotal;
        });
        grandTotalInput.value = 'Rp ' + grandTotal.toLocaleString('id-ID');
    }

    // Melampirkan event ke inputan yang ada di baris
    function attachEvents(row) {
        const select = row.querySelector('.select-barang');
        const inputHarga = row.querySelector('.input-harga');
        const inputQty = row.querySelector('.input-qty');
        
        select.addEventListener('change', function() {
            const harga = this.options[this.selectedIndex].getAttribute('data-harga');
            inputHarga.value = harga ? harga : 0;
            calculateTotal();
        });

        inputHarga.addEventListener('input', calculateTotal);
        inputQty.addEventListener('input', calculateTotal);
    }

    // Inisialisasi baris pertama
    attachEvents(tableBody.querySelector('tr'));

    // Tombol Tambah Baris
    document.getElementById('btn-tambah').addEventListener('click', function() {
        const firstRow = tableBody.querySelector('tr');
        const newRow = firstRow.cloneNode(true);
        newRow.querySelector('.select-barang').value = '';
        newRow.querySelector('.input-harga').value = '';
        newRow.querySelector('.input-qty').value = '1';
        newRow.querySelector('.input-subtotal').value = '';
        tableBody.appendChild(newRow);
        attachEvents(newRow); // Beri event pada baris yang baru ditambah
    });

    // Tombol Hapus Baris
    tableBody.addEventListener('click', function(e) {
        if(e.target.classList.contains('btn-hapus')) {
            if(tableBody.querySelectorAll('tr').length > 1) {
                e.target.closest('tr').remove();
                calculateTotal();
            } else {
                alert('Minimal harus ada 1 barang untuk dibeli!');
            }
        }
    });
});
</script>
@endsection