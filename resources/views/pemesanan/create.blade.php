@extends('layouts.app')

@section('title', 'Buat Pemesanan Baru')

@section('content')
<x-card title="Buat Pemesanan Baru" subtitle="Isi data pesanan barang ke supplier">
    <form action="{{ route('pemesanan.store') }}" method="POST" class="flex flex-col gap-5">
        @csrf

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-3">
            <div>
                <x-input-label for="kode_po" value="No. Pemesanan" />
                <x-text-input id="kode_po" name="kode_po" class="mt-1.5 bg-gray-50 text-gray-600" value="PO-{{ date('Ymd') }}-{{ rand(100,999) }}" readonly />
            </div>

            <div>
                <x-input-label for="tanggal" value="Tanggal Pesan" />
                <x-text-input id="tanggal" type="date" name="tanggal" class="mt-1.5" value="{{ date('Y-m-d') }}" required />
                <x-input-error :messages="$errors->get('tanggal')" class="mt-1.5" />
            </div>

            <div>
                <x-input-label for="supplier_id" value="Supplier" />
                <select id="supplier_id" name="supplier_id" class="mt-1.5 w-full rounded-lg border-gray-300 focus:border-purple-500 focus:ring-purple-200" required>
                    <option value="">-- Pilih Supplier --</option>
                    @foreach($suppliers as $sup)
                    <option value="{{ $sup->id }}">{{ $sup->kode }} - {{ $sup->nama }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('supplier_id')" class="mt-1.5" />
            </div>
        </div>

        <div>
            <x-input-label for="catatan" value="Catatan Pesanan" />
            <textarea id="catatan" name="catatan" rows="2" class="mt-1.5 w-full rounded-lg border-gray-300 focus:border-purple-500 focus:ring-purple-200" placeholder="Catatan tambahan jika ada"></textarea>
            <x-input-error :messages="$errors->get('catatan')" class="mt-1.5" />
        </div>

        <div class="space-y-3">
            <div class="flex items-center justify-between">
                <h3 class="text-sm font-semibold text-slate-700">Detail Barang Dipesan</h3>
                <button type="button" id="tambahBaris" class="text-sm font-medium text-purple-600 hover:text-purple-700">
                    + Tambah Baris Barang
                </button>
            </div>

            <div class="overflow-x-auto rounded-xl border border-purple-50">
                <table class="w-full text-sm">
                    <thead class="bg-purple-50/50">
                        <tr>
                            <th class="w-[35%] px-4 py-3 text-left font-medium text-purple-700">Pilih Barang</th>
                            <th class="w-[20%] px-4 py-3 text-right font-medium text-purple-700">Harga Satuan (Rp)</th>
                            <th class="w-[15%] px-4 py-3 text-center font-medium text-purple-700">Jumlah</th>
                            <th class="w-[20%] px-4 py-3 text-right font-medium text-purple-700">Subtotal</th>
                            <th class="w-[10%] px-4 py-3 text-center font-medium text-purple-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="daftarBarang">
                        <tr class="border-t border-purple-50">
                            <td class="px-4 py-3">
                                <select name="barang_id[]" class="select-barang w-full rounded-lg border-gray-300 px-3 py-2 focus:border-purple-500 focus:ring-purple-200">
                                    <option value="">-- Pilih Barang --</option>
                                    @foreach($barangs as $brg)
                                    <option value="{{ $brg->id }}" data-harga="{{ $brg->harga_beli }}">
                                        {{ $brg->kode }} - {{ $brg->judul }}
                                    </option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="px-4 py-3">
                                <input type="number" name="harga[]" class="input-harga w-full rounded-lg border-gray-300 px-3 py-2 text-right focus:border-purple-500 focus:ring-purple-200" min="0" value="0" readonly>
                            </td>
                            <td class="px-4 py-3">
                                <input type="number" name="qty[]" class="w-full rounded-lg border-gray-300 px-3 py-2 text-center focus:border-purple-500 focus:ring-purple-200" min="1" value="1">
                            </td>
                            <td class="px-4 py-3 text-right font-semibold text-slate-700">Rp 0</td>
                            <td class="px-4 py-3 text-center">
                                <button type="button" class="hapus-baris rounded px-2 py-1 text-red-500 hover:bg-red-50 hover:text-red-700 font-bold">×</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="flex items-center gap-3 border-t border-purple-50 pt-5">
            <x-button type="submit" variant="primary">Simpan Pemesanan</x-button>
            <x-button as="a" href="{{ route('pemesanan.index') }}" variant="ghost">Batal</x-button>
        </div>
    </form>
</x-card>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const daftarBarang = document.getElementById('daftarBarang');
    const tombolTambah = document.getElementById('tambahBaris');

    // Hitung ulang subtotal
    function hitungSubtotal(row) {
        const harga = parseFloat(row.querySelector('.input-harga').value) || 0;
        const qty = parseInt(row.querySelector('input[name="qty[]"]').value) || 0;
        const kolomSubtotal = row.querySelector('td:last-child').previousElementSibling;
        kolomSubtotal.textContent = `Rp ${(harga * qty).toLocaleString('id-ID')}`;
    }

    // Pasang event ke satu baris
    function pasangEventBaris(row) {
        // Isi harga otomatis saat pilih barang
        const selectBarang = row.querySelector('.select-barang');
        const inputHarga = row.querySelector('.input-harga');
        selectBarang.addEventListener('change', function() {
            const harga = this.selectedOptions[0]?.dataset.harga || 0;
            inputHarga.value = harga;
            inputHarga.removeAttribute('readonly');
            hitungSubtotal(row);
        });

        // Hitung ulang saat ubah harga atau jumlah
        inputHarga.addEventListener('input', () => hitungSubtotal(row));
        row.querySelector('input[name="qty[]"]').addEventListener('input', () => hitungSubtotal(row));

        // Hapus baris
        row.querySelector('.hapus-baris').addEventListener('click', function() {
            if (daftarBarang.rows.length > 1) {
                row.remove();
            } else {
                alert('Minimal harus ada 1 barang yang dipesan!');
            }
        });
    }

    // Pasang event ke baris pertama
    pasangEventBaris(daftarBarang.rows[0]);

    // Tambah baris baru
    tombolTambah.addEventListener('click', function() {
        const barisPertama = daftarBarang.rows[0];
        const barisBaru = barisPertama.cloneNode(true);
        
        // Reset nilai di baris baru
        barisBaru.querySelector('.select-barang').value = '';
        barisBaru.querySelector('.input-harga').value = '0';
        barisBaru.querySelector('.input-harga').setAttribute('readonly', 'true');
        barisBaru.querySelector('input[name="qty[]"]').value = '1';
        barisBaru.querySelector('td:last-child').previousElementSibling.textContent = 'Rp 0';
        
        daftarBarang.appendChild(barisBaru);
        pasangEventBaris(barisBaru);
    });
});
</script>
@endsection