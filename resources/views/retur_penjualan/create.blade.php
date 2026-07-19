@extends('layouts.app')

@section('title', 'Form Retur Penjualan')

@section('content')
<x-card title="Form Retur Penjualan" subtitle="Pengembalian barang dari konsumen dan penambahan stok">
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

    <form action="{{ route('retur-penjualan.store') }}" method="POST" class="flex flex-col gap-5">
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
                <x-input-label for="select_penjualan" value="Pilih Transaksi Penjualan Awal" />
                <select id="select_penjualan" name="penjualan_id" class="mt-1.5 w-full rounded-lg border-gray-300 focus:border-purple-500 focus:ring-purple-200" required>
                    <option value="">-- Pilih Referensi Penjualan --</option>
                    @foreach($penjualans as $pj)
                        <option value="{{ $pj->id }}" data-konsumen-id="{{ $pj->konsumen_id }}" data-konsumen-nama="{{ $pj->konsumen->nama ?? '-' }}">
                            {{ $pj->no_jual }} - {{ $pj->konsumen->nama ?? 'Tanpa Konsumen' }}
                        </option>
                    @endforeach
                </select>
            </div>

            <input type="hidden" name="konsumen_id" id="konsumen_id">
            <div>
                <x-input-label for="konsumen_nama" value="Konsumen (Otomatis)" />
                <x-text-input id="konsumen_nama" class="mt-1.5 bg-gray-50 text-gray-600" readonly />
            </div>

            <div class="lg:col-span-2">
                <x-input-label for="alasan" value="Keterangan / Alasan Retur" />
                <x-text-input id="alasan" name="alasan" class="mt-1.5" required placeholder="Contoh: Barang cacat / Salah ukuran / Salah judul" />
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
            <x-button type="submit" variant="primary">Proses Retur & Tambah Stok</x-button>
            <x-button as="a" href="{{ route('retur-penjualan.index') }}" variant="ghost">Batal</x-button>
        </div>
    </form>
</x-card>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const daftarBarang = document.getElementById('daftarBarang');
    const tombolTambah = document.getElementById('tambahBaris');
    const selectPenjualan = document.getElementById('select_penjualan');
    const inputKonsumenId = document.getElementById('konsumen_id');
    const inputKonsumenNama = document.getElementById('konsumen_nama');

    // Isi konsumen otomatis saat pilih penjualan
    selectPenjualan.addEventListener('change', function() {
        const selected = this.selectedOptions[0];
        if (this.value) {
            inputKonsumenId.value = selected.dataset.konsumenId;
            inputKonsumenNama.value = selected.dataset.konsumenNama;
        } else {
            inputKonsumenId.value = '';
            inputKonsumenNama.value = '';
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