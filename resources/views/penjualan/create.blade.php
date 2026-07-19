@extends('layouts.app')

@section('title', 'Transaksi Penjualan (Kasir)')

@section('content')
<x-card title="Transaksi Penjualan (Kasir)" subtitle="Isi data transaksi penjualan barang">
    @if(session('error'))
        <div class="mb-4 rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-700">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('penjualan.store') }}" method="POST" class="flex flex-col gap-5">
        @csrf

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
            <div>
                <x-input-label for="no_jual" value="No. Penjualan" />
                <x-text-input id="no_jual" name="no_jual" class="mt-1.5 bg-gray-50 text-gray-600" value="{{ $no_jual }}" readonly />
            </div>

            <div>
                <x-input-label for="tgl_jual" value="Tanggal" />
                <x-text-input id="tgl_jual" type="date" name="tgl_jual" class="mt-1.5" value="{{ date('Y-m-d') }}" required />
            </div>

            <div>
                <x-input-label for="konsumen_id" value="Konsumen" />
                <select id="konsumen_id" name="konsumen_id" class="mt-1.5 w-full rounded-lg border-gray-300 focus:border-purple-500 focus:ring-purple-200" required>
                    <option value="">-- Pilih Konsumen --</option>
                    @foreach($konsumens as $konsumen)
                        <option value="{{ $konsumen->id }}">{{ $konsumen->nama }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <x-input-label for="supplier_id" value="Supplier" />
                <select id="supplier_id" name="supplier_id" class="mt-1.5 w-full rounded-lg border-gray-300 focus:border-purple-500 focus:ring-purple-200" required>
                    <option value="">-- Pilih Supplier --</option>
                    @foreach($suppliers as $supplier)
                        <option value="{{ $supplier->id }}">{{ $supplier->nama }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <x-input-label for="tipe" value="Tipe Pembayaran" />
                <select id="tipe" name="tipe" class="mt-1.5 w-full rounded-lg border-gray-300 focus:border-purple-500 focus:ring-purple-200" required>
                    <option value="cash">CASH (Tunai)</option>
                    <option value="credit">CREDIT (Piutang)</option>
                </select>
            </div>

            <div id="div_jatuh_tempo" class="hidden">
                <x-input-label for="jatuh_tempo" value="Tanggal Jatuh Tempo" />
                <x-text-input id="jatuh_tempo" type="date" name="jatuh_tempo" class="mt-1.5" />
            </div>
        </div>

        <div class="space-y-3">
            <h3 class="text-sm font-semibold text-slate-700">Keranjang Belanja</h3>

            <div class="overflow-x-auto rounded-xl border border-purple-50">
                <table class="w-full text-sm">
                    <thead class="bg-purple-50/50">
                        <tr>
                            <th class="w-[30%] px-4 py-3 text-left font-medium text-purple-700">Pilih Barang</th>
                            <th class="w-[15%] px-4 py-3 text-right font-medium text-purple-700">Harga (Rp)</th>
                            <th class="w-[10%] px-4 py-3 text-center font-medium text-purple-700">Qty</th>
                            <th class="w-[15%] px-4 py-3 text-right font-medium text-purple-700">Diskon (Rp)</th>
                            <th class="w-[20%] px-4 py-3 text-right font-medium text-purple-700">Subtotal (Rp)</th>
                            <th class="w-[10%] px-4 py-3 text-center font-medium text-purple-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="daftarBarang">
                        <tr class="border-t border-purple-50">
                            <td class="px-4 py-3">
                                <select name="barang_id[]" class="select-barang w-full rounded-lg border-gray-300 px-3 py-2 focus:border-purple-500 focus:ring-purple-200" required>
                                    <option value="">-- Pilih Barang --</option>
                                    @foreach($barangs as $barang)
                                        <option value="{{ $barang->id }}" data-harga="{{ $barang->harga_jual }}" data-stok="{{ $barang->stok }}">
                                            {{ $barang->kode }} - {{ $barang->judul }} (Sisa: {{ $barang->stok }})
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="px-4 py-3">
                                <input type="number" name="harga_satuan[]" class="input-harga w-full rounded-lg border-gray-300 px-3 py-2 text-right focus:border-purple-500 focus:ring-purple-200 bg-gray-50" readonly>
                            </td>
                            <td class="px-4 py-3">
                                <input type="number" name="qty[]" class="input-qty w-full rounded-lg border-gray-300 px-3 py-2 text-center focus:border-purple-500 focus:ring-purple-200" min="1" value="1" required>
                            </td>
                            <td class="px-4 py-3">
                                <input type="number" name="diskon[]" class="input-diskon w-full rounded-lg border-gray-300 px-3 py-2 text-right focus:border-purple-500 focus:ring-purple-200" min="0" value="0">
                            </td>
                            <td class="px-4 py-3">
                                <input type="text" class="input-subtotal w-full rounded-lg border-gray-200 bg-gray-50 px-3 py-2 text-right font-medium text-slate-700" readonly>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <button type="button" class="hapus-baris rounded px-2 py-1 text-red-500 hover:bg-red-50 hover:text-red-700 font-bold">×</button>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot class="bg-purple-50/50">
                        <tr>
                            <td colspan="4" class="px-4 py-3 text-right font-bold text-purple-700">GRAND TOTAL:</td>
                            <td colspan="2" class="px-4 py-3">
                                <input type="text" id="grand_total" class="w-full rounded-lg border-gray-200 bg-white px-3 py-2 text-right text-lg font-bold text-red-700" readonly>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <button type="button" id="tambahBaris" class="text-sm font-medium text-purple-600 hover:text-purple-700">
                + Tambah Barang
            </button>
        </div>

        <div class="flex items-center gap-3 border-t border-purple-50 pt-5">
            <x-button type="submit" variant="primary">Simpan Transaksi</x-button>
            <x-button as="a" href="{{ route('penjualan.index') }}" variant="ghost">Batal</x-button>
        </div>
    </form>
</x-card>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const daftarBarang = document.getElementById('daftarBarang');
    const tombolTambah = document.getElementById('tambahBaris');
    const inputGrandTotal = document.getElementById('grand_total');
    const selectTipe = document.getElementById('tipe');
    const divJatuhTempo = document.getElementById('div_jatuh_tempo');
    const inputJatuhTempo = document.getElementById('jatuh_tempo');

    // Tampilkan/sembunyikan jatuh tempo
    selectTipe.addEventListener('change', function() {
        if (this.value === 'credit') {
            divJatuhTempo.classList.remove('hidden');
            inputJatuhTempo.setAttribute('required', 'true');
        } else {
            divJatuhTempo.classList.add('hidden');
            inputJatuhTempo.removeAttribute('required');
            inputJatuhTempo.value = '';
        }
    });

    // Hitung total
    function hitungSemuaTotal() {
        let totalKeseluruhan = 0;
        daftarBarang.querySelectorAll('tr').forEach(baris => {
            const harga = parseFloat(baris.querySelector('.input-harga').value) || 0;
            const qty = parseFloat(baris.querySelector('.input-qty').value) || 0;
            const diskon = parseFloat(baris.querySelector('.input-diskon').value) || 0;
            const subtotal = Math.max((harga * qty) - diskon, 0);
            
            baris.querySelector('.input-subtotal').value = `Rp ${subtotal.toLocaleString('id-ID')}`;
            totalKeseluruhan += subtotal;
        });
        inputGrandTotal.value = `Rp ${totalKeseluruhan.toLocaleString('id-ID')}`;
    }

    // Pasang event ke baris
    function pasangEventBaris(baris) {
        const selectBarang = baris.querySelector('.select-barang');
        const inputHarga = baris.querySelector('.input-harga');
        const inputQty = baris.querySelector('.input-qty');
        
        selectBarang.addEventListener('change', function() {
            const harga = this.selectedOptions[0]?.dataset.harga || 0;
            const stok = this.selectedOptions[0]?.dataset.stok || 1;
            inputHarga.value = harga;
            inputQty.setAttribute('max', stok);
            hitungSemuaTotal();
        });

        baris.querySelector('.input-harga').addEventListener('input', hitungSemuaTotal);
        baris.querySelector('.input-qty').addEventListener('input', hitungSemuaTotal);
        baris.querySelector('.input-diskon').addEventListener('input', hitungSemuaTotal);

        // Hapus baris
        baris.querySelector('.hapus-baris').addEventListener('click', function() {
            if (daftarBarang.rows.length > 1) {
                baris.remove();
                hitungSemuaTotal();
            } else {
                alert('Minimal harus ada 1 barang!');
            }
        });
    }

    // Inisialisasi
    pasangEventBaris(daftarBarang.rows[0]);
    hitungSemuaTotal();

    // Tambah baris baru
    tombolTambah.addEventListener('click', function() {
        const barisPertama = daftarBarang.rows[0];
        const barisBaru = barisPertama.cloneNode(true);
        
        barisBaru.querySelector('.select-barang').value = '';
        barisBaru.querySelector('.input-harga').value = '';
        barisBaru.querySelector('.input-qty').value = '1';
        barisBaru.querySelector('.input-qty').removeAttribute('max');
        barisBaru.querySelector('.input-diskon').value = '0';
        barisBaru.querySelector('.input-subtotal').value = '';
        
        daftarBarang.appendChild(barisBaru);
        pasangEventBaris(barisBaru);
    });
});
</script>
@endsection