@extends('layouts.app')

@section('title', 'Form Retur Pembelian')

@section('content')
<x-card title="Form Retur Pembelian" subtitle="Pengembalian barang ke supplier dan pengurangan stok">
    @if ($errors->any())
        <div class="mb-4 rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-700">
            <strong>Gagal Menyimpan!</strong> Periksa kembali isian Anda:
            <ul class="mb-0 mt-2 list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-4 rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-700">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('retur-pembelian.store') }}" method="POST" class="flex flex-col gap-5">
        @csrf

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
            <div>
                <x-input-label for="no_retur" value="No. Retur" />
                <x-text-input id="no_retur" name="no_retur" class="mt-1.5 bg-gray-50 text-gray-600" value="{{ $no_retur }}" readonly />
            </div>

            <div>
                <x-input-label for="tgl_retur" value="Tanggal Retur" />
                <x-text-input id="tgl_retur" type="date" name="tgl_retur" class="mt-1.5" value="{{ date('Y-m-d') }}" required />
            </div>

            <div class="lg:col-span-2">
                <x-input-label for="select_pembelian" value="Pilih Transaksi Pembelian Awal" />
                <select id="select_pembelian" name="pembelian_id" class="mt-1.5 w-full rounded-lg border-gray-300 focus:border-purple-500 focus:ring-purple-200" required>
                    <option value="">-- Pilih Referensi Pembelian --</option>
                    @foreach($pembelians as $pb)
                        <option value="{{ $pb->id }}" data-supplier-id="{{ $pb->supplier_id }}" data-supplier-nama="{{ $pb->supplier->nama }}">
                            {{ $pb->no_beli }} - {{ $pb->supplier->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            <input type="hidden" name="supplier_id" id="supplier_id">
            <div>
                <x-input-label for="supplier_nama" value="Supplier (Otomatis)" />
                <x-text-input id="supplier_nama" class="mt-1.5 bg-gray-50 text-gray-600" readonly />
            </div>

            <div class="lg:col-span-2">
                <x-input-label for="alasan" value="Keterangan / Alasan Retur" />
                <x-text-input id="alasan" name="alasan" class="mt-1.5" placeholder="Contoh: Barang cacat dari pabrik / Salah kirim judul" required />
            </div>
        </div>

        <div class="space-y-3">
            <h3 class="text-sm font-semibold text-slate-700">Daftar Barang yang Diretur</h3>

            <div class="overflow-x-auto rounded-xl border border-purple-50">
                <table class="w-full text-sm">
                    <thead class="bg-purple-50/50">
                        <tr>
                            <th class="w-[60%] px-4 py-3 text-left font-medium text-purple-700">Pilih Barang</th>
                            <th class="w-[30%] px-4 py-3 text-center font-medium text-purple-700">Qty Retur</th>
                            <th class="w-[10%] px-4 py-3 text-center font-medium text-purple-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="daftarBarang">
                        <tr class="border-t border-purple-50">
                            <td class="px-4 py-3">
                                <select name="barang_id[]" class="select-barang w-full rounded-lg border-gray-300 px-3 py-2 focus:border-purple-500 focus:ring-purple-200" required>
                                    <option value="">-- Pilih Barang --</option>
                                    @foreach($barangs as $barang)
                                        <option value="{{ $barang->id }}" data-stok="{{ $barang->stok }}">
                                            {{ $barang->kode }} - {{ $barang->judul }} (Stok saat ini: {{ $barang->stok }})
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="px-4 py-3">
                                <input type="number" name="qty[]" class="input-qty w-full rounded-lg border-gray-300 px-3 py-2 text-center focus:border-purple-500 focus:ring-purple-200" min="1" value="1" required>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <button type="button" class="hapus-baris rounded px-2 py-1 text-red-500 hover:bg-red-50 hover:text-red-700 font-bold">×</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <button type="button" id="tambahBaris" class="text-sm font-medium text-purple-600 hover:text-purple-700">
                + Tambah Barang
            </button>
        </div>

        <div class="flex items-center gap-3 border-t border-purple-50 pt-5">
            <x-button type="submit" variant="primary">Proses Retur & Kurangi Stok</x-button>
            <x-button as="a" href="{{ route('retur-pembelian.index') }}" variant="ghost">Batal</x-button>
        </div>
    </form>
</x-card>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const daftarBarang = document.getElementById('daftarBarang');
    const tombolTambah = document.getElementById('tambahBaris');
    const selectPembelian = document.getElementById('select_pembelian');
    const inputSupplierId = document.getElementById('supplier_id');
    const inputSupplierNama = document.getElementById('supplier_nama');

    // Isi supplier otomatis saat pilih pembelian
    selectPembelian.addEventListener('change', function() {
        const selected = this.selectedOptions[0];
        if (this.value) {
            inputSupplierId.value = selected.dataset.supplierId;
            inputSupplierNama.value = selected.dataset.supplierNama;
        } else {
            inputSupplierId.value = '';
            inputSupplierNama.value = '';
        }
    });

    // Pasang batas stok ke baris
    function pasangEventBaris(baris) {
        const selectBarang = baris.querySelector('.select-barang');
        const inputQty = baris.querySelector('.input-qty');
        
        selectBarang.addEventListener('change', function() {
            const stok = this.selectedOptions[0]?.dataset.stok || 1;
            inputQty.setAttribute('max', stok);
        });

        // Hapus baris
        baris.querySelector('.hapus-baris').addEventListener('click', function() {
            if (daftarBarang.rows.length > 1) {
                baris.remove();
            } else {
                alert('Minimal 1 barang harus diretur!');
            }
        });
    }

    // Inisialisasi baris pertama
    pasangEventBaris(daftarBarang.rows[0]);

    // Tambah baris baru
    tombolTambah.addEventListener('click', function() {
        const barisPertama = daftarBarang.rows[0];
        const barisBaru = barisPertama.cloneNode(true);
        
        barisBaru.querySelector('.select-barang').value = '';
        barisBaru.querySelector('.input-qty').value = '1';
        barisBaru.querySelector('.input-qty').removeAttribute('max');
        
        daftarBarang.appendChild(barisBaru);
        pasangEventBaris(barisBaru);
    });
});
</script>
@endsection