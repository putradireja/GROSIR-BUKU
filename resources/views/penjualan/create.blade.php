@extends('layouts.app')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-danger text-white">
        <h5 class="mb-0">Transaksi Penjualan (Kasir)</h5>
    </div>
    <div class="card-body">
        @if(session('error')) <div class="alert alert-danger">{{ session('error') }}</div> @endif
        
        <form action="{{ route('penjualan.store') }}" method="POST">
            @csrf
            <div class="row mb-4">
                <div class="col-md-3 mb-3">
                    <label>No. Penjualan</label>
                    <input type="text" name="no_jual" class="form-control" value="{{ $no_jual }}" readonly>
                </div>
                <div class="col-md-3 mb-3">
                    <label>Tanggal</label>
                    <input type="date" name="tgl_jual" class="form-control" value="{{ date('Y-m-d') }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Konsumen</label>
                    <select name="konsumen_id" class="form-control" required>
                        <option value="">-- Pilih Konsumen --</option>
                        @foreach($konsumens as $konsumen)
                            <option value="{{ $konsumen->id }}">{{ $konsumen->nama }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-md-3 mb-3">
                    <label>Tipe Pembayaran</label>
                    <select name="tipe" id="tipe_bayar" class="form-control" required>
                        <option value="cash">CASH (Tunai)</option>
                        <option value="credit">CREDIT (Piutang)</option>
                    </select>
                </div>
                <div class="col-md-3 mb-3 d-none" id="div_jatuh_tempo">
                    <label>Tanggal Jatuh Tempo</label>
                    <input type="date" name="jatuh_tempo" id="jatuh_tempo" class="form-control">
                </div>
            </div>

            <h5 class="border-bottom pb-2">Keranjang Belanja</h5>
            <table class="table table-bordered" id="table-detail">
                <thead class="table-light">
                    <tr>
                        <th>Pilih Barang</th>
                        <th width="150px">Harga (Rp)</th>
                        <th width="100px">Qty</th>
                        <th width="150px">Diskon (Rp)</th>
                        <th width="180px">Subtotal (Rp)</th>
                        <th width="60px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <select name="barang_id[]" class="form-control select-barang" required>
                                <option value="">-- Pilih Barang --</option>
                                @foreach($barangs as $barang)
                                    <option value="{{ $barang->id }}" data-harga="{{ $barang->harga_jual }}" data-stok="{{ $barang->stok }}">
                                        {{ $barang->kode }} - {{ $barang->judul }} (Sisa: {{ $barang->stok }})
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td><input type="number" name="harga_satuan[]" class="form-control input-harga" readonly></td>
                        <td><input type="number" name="qty[]" class="form-control input-qty" value="1" min="1" required></td>
                        <td><input type="number" name="diskon[]" class="form-control input-diskon" value="0" min="0"></td>
                        <td><input type="text" class="form-control input-subtotal" readonly></td>
                        <td><button type="button" class="btn btn-danger btn-sm btn-hapus">X</button></td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" class="text-end"><strong>GRAND TOTAL:</strong></td>
                        <td colspan="2"><input type="text" id="grand_total" class="form-control fw-bold text-danger fs-5" readonly></td>
                    </tr>
                </tfoot>
            </table>
            <button type="button" class="btn btn-danger btn-sm mb-4" id="btn-tambah">+ Tambah Barang</button>

            <hr>
            <button type="submit" class="btn btn-primary">Simpan Transaksi</button>
            <a href="{{ route('penjualan.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tableBody = document.querySelector('#table-detail tbody');
    const grandTotalInput = document.getElementById('grand_total');
    
    // Tampilkan jatuh tempo jika credit
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

    function calculateTotal() {
        let grandTotal = 0;
        tableBody.querySelectorAll('tr').forEach(row => {
            const harga = parseFloat(row.querySelector('.input-harga').value) || 0;
            const qty = parseFloat(row.querySelector('.input-qty').value) || 0;
            const diskon = parseFloat(row.querySelector('.input-diskon').value) || 0;
            
            const subtotal = (harga * qty) - diskon;
            row.querySelector('.input-subtotal').value = subtotal > 0 ? subtotal : 0;
            grandTotal += subtotal > 0 ? subtotal : 0;
        });
        grandTotalInput.value = 'Rp ' + grandTotal.toLocaleString('id-ID');
    }

    function attachEvents(row) {
        const select = row.querySelector('.select-barang');
        const inputHarga = row.querySelector('.input-harga');
        const inputQty = row.querySelector('.input-qty');
        const inputDiskon = row.querySelector('.input-diskon');
        
        select.addEventListener('change', function() {
            const harga = this.options[this.selectedIndex].getAttribute('data-harga');
            const stok = this.options[this.selectedIndex].getAttribute('data-stok');
            inputHarga.value = harga ? harga : 0;
            inputQty.setAttribute('max', stok ? stok : 1); // Batasi maksimal input Qty sesuai stok
            calculateTotal();
        });

        inputHarga.addEventListener('input', calculateTotal);
        inputQty.addEventListener('input', calculateTotal);
        inputDiskon.addEventListener('input', calculateTotal);
    }

    attachEvents(tableBody.querySelector('tr'));

    document.getElementById('btn-tambah').addEventListener('click', function() {
        const firstRow = tableBody.querySelector('tr');
        const newRow = firstRow.cloneNode(true);
        newRow.querySelector('.select-barang').value = '';
        newRow.querySelector('.input-harga').value = '';
        newRow.querySelector('.input-qty').value = '1';
        newRow.querySelector('.input-qty').removeAttribute('max');
        newRow.querySelector('.input-diskon').value = '0';
        newRow.querySelector('.input-subtotal').value = '';
        tableBody.appendChild(newRow);
        attachEvents(newRow);
    });

    tableBody.addEventListener('click', function(e) {
        if(e.target.classList.contains('btn-hapus')) {
            if(tableBody.querySelectorAll('tr').length > 1) {
                e.target.closest('tr').remove();
                calculateTotal();
            } else {
                alert('Minimal harus ada 1 barang!');
            }
        }
    });
});
</script>
@endsection