@extends('layouts.app')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-secondary text-white">
        <h5 class="mb-0">Form Retur Penjualan (Kurangi Stok)</h5>
    </div>
    <div class="card-body">
        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Gagal Menyimpan!</strong> Periksa kembali isian Anda:
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                </ul>
            </div>
        @endif
        @if(session('error')) <div class="alert alert-danger">{{ session('error') }}</div> @endif
        
        <form action="{{ route('retur-penjualan.store') }}" method="POST">
            @csrf
            <div class="row mb-4">
                <div class="col-md-3 mb-3">
                    <label>No. Retur</label>
                    <input type="text" name="no_retur" class="form-control" value="{{ $no_retur }}" readonly>
                </div>
                <div class="col-md-3 mb-3">
                    <label>Tanggal Retur</label>
                    <input type="date" name="tgl_retur" class="form-control" value="{{ date('Y-m-d') }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Pilih Transaksi Penjualan Awal</label>
                    <select name="penjualan_id" id="select_penjualan" class="form-control" required>
                        <option value="">-- Pilih Referensi Penjualan --</option>
                        @foreach($penjualans as $pj)
                            <option value="{{ $pj->id }}" data-konsumen-id="{{ $pj->konsumen_id }}" data-konsumen-nama="{{ $pj->konsumen->nama ?? '-' }}">
                                {{ $pj->no_jual }} - {{ $pj->konsumen->nama ?? 'Tanpa Konsumen'}}
                            </option>
                        @endforeach
                    </select>
                </div>

                <input type="hidden" name="konsumen_id" id="konsumen_id">
                <div class="col-md-6 mb-3">
                    <label>Konsumen (Otomatis)</label>
                    <input type="text" id="konsumen_nama" class="form-control bg-light" readonly>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Keterangan / Alasan Retur</label>
                    <input type="text" name="keterangan" class="form-control" placeholder="Contoh: Barang cacat dari pabrik / Salah kirim judul">
                </div>
            </div>

            <h5 class="border-bottom pb-2">Daftar Barang yang Diretur</h5>
            <table class="table table-bordered" id="table-detail">
                <thead class="table-light">
                    <tr>
                        <th>Pilih Barang</th>
                        <th width="150px">Qty Retur</th>
                        <th width="80px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <select name="barang_id[]" class="form-control select-barang" required>
                                <option value="">-- Pilih Barang --</option>
                                @foreach($barangs as $barang)
                                    <option value="{{ $barang->id }}" data-stok="{{ $barang->stok }}">
                                        {{ $barang->kode }} - {{ $barang->judul }} (Stok saat ini: {{ $barang->stok }})
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td><input type="number" name="qty[]" class="form-control input-qty" value="1" min="1" required></td>
                        <td><button type="button" class="btn btn-danger btn-sm btn-hapus">X</button></td>
                    </tr>
                </tbody>
            </table>
            <button type="button" class="btn btn-secondary btn-sm mb-4" id="btn-tambah">+ Tambah Barang</button>

            <hr>
            <button type="submit" class="btn btn-primary">Proses Retur & Kurangi Stok</button>
            <a href="{{ route('retur-penjualan.index') }}" class="btn btn-outline-secondary">Batal</a>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tableBody = document.querySelector('#table-detail tbody');

    // Auto-fill Konsumen
    document.getElementById('select_penjualan').addEventListener('change', function() {
        const selected = this.options[this.selectedIndex];
        if (this.value) {
            document.getElementById('konsumen_id').value = selected.getAttribute('data-konsumen-id');
            document.getElementById('konsumen_nama').value = selected.getAttribute('data-konsumen-nama');
        } else {
            document.getElementById('konsumen_id').value = '';
            document.getElementById('konsumen_nama').value = '';
        }
    });

    // Batasi input QTY max sejumlah stok gudang
    function attachEvents(row) {
        const select = row.querySelector('.select-barang');
        const inputQty = row.querySelector('.input-qty');
        select.addEventListener('change', function() {
            const stok = this.options[this.selectedIndex].getAttribute('data-stok');
            inputQty.setAttribute('max', stok ? stok : 1);
        });
    }

    attachEvents(tableBody.querySelector('tr'));

    // Tambah Baris
    document.getElementById('btn-tambah').addEventListener('click', function() {
        const newRow = tableBody.querySelector('tr').cloneNode(true);
        newRow.querySelector('.select-barang').value = '';
        newRow.querySelector('.input-qty').value = '1';
        newRow.querySelector('.input-qty').removeAttribute('max');
        tableBody.appendChild(newRow);
        attachEvents(newRow);
    });

    // Hapus Baris
    tableBody.addEventListener('click', function(e) {
        if(e.target.classList.contains('btn-hapus')) {
            if(tableBody.querySelectorAll('tr').length > 1) {
                e.target.closest('tr').remove();
            } else {
                alert('Minimal 1 barang harus diretur!');
            }
        }
    });
});
</script>
@endsection