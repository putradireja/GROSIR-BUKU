@extends('layouts.app')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Buat Pemesanan Baru</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('pemesanan.store') }}" method="POST">
            @csrf
            <div class="row mb-4">
                <div class="col-md-4 mb-3">
                    <label>No. Pesanan</label>
                    <input type="text" name="no_pesan" class="form-control" value="{{ $no_pesan }}" readonly>
                </div>
                <div class="col-md-4 mb-3">
                    <label>Tanggal Pesan</label>
                    <input type="date" name="tgl_pesan" class="form-control" value="{{ date('Y-m-d') }}" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label>Supplier</label>
                    <select name="supplier_id" class="form-control" required>
                        <option value="">-- Pilih Supplier --</option>
                        @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->id }}">{{ $supplier->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-12">
                    <label>Catatan</label>
                    <textarea name="catatan" class="form-control" rows="2"></textarea>
                </div>
            </div>

            <h5 class="border-bottom pb-2">Detail Barang</h5>
            <table class="table table-bordered" id="table-detail">
                <thead class="table-light">
                    <tr>
                        <th>Pilih Barang</th>
                        <th width="150px">Harga Satuan (Rp)</th>
                        <th width="120px">Qty</th>
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
                        <td><input type="number" name="harga_satuan[]" class="form-control input-harga" required readonly></td>
                        <td><input type="number" name="qty[]" class="form-control" value="1" min="1" required></td>
                        <td><button type="button" class="btn btn-danger btn-sm btn-hapus">X</button></td>
                    </tr>
                </tbody>
            </table>
            <button type="button" class="btn btn-success btn-sm mb-4" id="btn-tambah">+ Tambah Baris Barang</button>

            <hr>
            <button type="submit" class="btn btn-primary">Simpan Pemesanan</button>
            <a href="{{ route('pemesanan.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tableBody = document.querySelector('#table-detail tbody');
    
    // Fungsi untuk mengisi harga otomatis
    function attachEventSelect(row) {
        const select = row.querySelector('.select-barang');
        const inputHarga = row.querySelector('.input-harga');
        
        select.addEventListener('change', function() {
            const harga = this.options[this.selectedIndex].getAttribute('data-harga');
            inputHarga.value = harga ? harga : 0;
            // Lepas readonly agar user bisa nego/ubah harga saat pesan
            inputHarga.removeAttribute('readonly'); 
        });
    }

    // Attach event ke baris pertama
    attachEventSelect(tableBody.querySelector('tr'));

    // Tambah Baris
    document.getElementById('btn-tambah').addEventListener('click', function() {
        const firstRow = tableBody.querySelector('tr');
        const newRow = firstRow.cloneNode(true);
        
        // Reset inputan di baris baru
        newRow.querySelector('.select-barang').value = '';
        newRow.querySelector('.input-harga').value = '';
        newRow.querySelector('.input-harga').setAttribute('readonly', 'true');
        newRow.querySelector('input[name="qty[]"]').value = '1';
        
        tableBody.appendChild(newRow);
        attachEventSelect(newRow); // Attach event harga ke baris baru
    });

    // Hapus Baris
    tableBody.addEventListener('click', function(e) {
        if(e.target.classList.contains('btn-hapus')) {
            if(tableBody.querySelectorAll('tr').length > 1) {
                e.target.closest('tr').remove();
            } else {
                alert('Minimal harus ada 1 barang!');
            }
        }
    });
});
</script>
@endsection