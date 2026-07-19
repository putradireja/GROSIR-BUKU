@extends('layouts.app')

@section('title', 'Buat Pembelian Baru')

@section('content')
<x-card title="Buat Pembelian Baru" subtitle="Isi data penerimaan barang dari supplier">
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

    <form action="{{ route('pembelian.store') }}" method="POST" class="flex flex-col gap-5">
        @csrf

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
            <div>
                <x-input-label for="no_beli" value="No. Pembelian" />
                <x-text-input id="no_beli" name="no_beli" class="mt-1.5 bg-gray-50 text-gray-600" value="{{ $no_beli }}" readonly />
            </div>

            <div>
                <x-input-label for="tgl_beli" value="Tanggal Masuk" />
                <x-text-input id="tgl_beli" type="date" name="tgl_beli" class="mt-1.5" value="{{ date('Y-m-d') }}" required />
                <x-input-error :messages="$errors->get('tgl_beli')" class="mt-1.5" />
            </div>

            <div>
                <x-input-label for="supplier_id" value="Supplier" />
                <select id="supplier_id" name="supplier_id" class="mt-1.5 w-full rounded-lg border-gray-300 focus:border-purple-500 focus:ring-purple-200" required>
                    <option value="">-- Pilih Supplier --</option>
                    @foreach($suppliers as $supplier)
                        <option value="{{ $supplier->id }}">{{ $supplier->nama }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('supplier_id')" class="mt-1.5" />
            </div>

            <div>
                <x-input-label for="pemesanan_id" value="Ref. Pemesanan (PO) - Opsional" />
                <select id="pemesanan_id" name="pemesanan_id" class="mt-1.5 w-full rounded-lg border-gray-300 focus:border-purple-500 focus:ring-purple-200">
                    <option value="">-- Tanpa PO --</option>
                    @foreach($pemesanans as $po)
                        <option value="{{ $po->id }}">{{ $po->no_pesan }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <x-input-label for="tipe" value="Tipe Pembayaran" />
                <select id="tipe" name="tipe" class="mt-1.5 w-full rounded-lg border-gray-300 focus:border-purple-500 focus:ring-purple-200" required>
                    <option value="cash">CASH (Tunai)</option>
                    <option value="credit">CREDIT (Hutang)</option>
                </select>
                <x-input-error :messages="$errors->get('tipe')" class="mt-1.5" />
            </div>

            <div id="div_jatuh_tempo" class="hidden">
                <x-input-label for="jatuh_tempo" value="Tanggal Jatuh Tempo" />
                <x-text-input id="jatuh_tempo" type="date" name="jatuh_tempo" class="mt-1.5" />
                <x-input-error :messages="$errors->get('jatuh_tempo')" class="mt-1.5" />
            </div>
        </div>

        <div class="space-y-3">
            <h3 class="text-sm font-semibold text-slate-700">Detail Barang Masuk</h3>

            <div class="overflow-x-auto rounded-xl border border-purple-50">
                <table class="w-full text-sm">
                    <thead class="bg-purple-50/50">
                        <tr>
                            <th class="w-[35%] px-4 py-3 text-left font-medium text-purple-700">Pilih Barang</th>
                            <th class="w-[20%] px-4 py-3 text-right font-medium text-purple-700">Harga Beli Satuan (Rp)</th>
                            <th class="w-[15%] px-4 py-3 text-center font-medium text-purple-700">Qty (Masuk)</th>
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
                                        <option value="{{ $barang->id }}" data-harga="{{ $barang->harga_beli }}">
                                            {{ $barang->kode }} - {{ $barang->judul }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="px-4 py-3">
                                <input type="number" name="harga_satuan[]" class="input-harga w-full rounded-lg border-gray-300 px-3 py-2 text-right focus:border-purple-500 focus:ring-purple-200" min="0" required>
                            </td>
                            <td class="px-4 py-3">
                                <input type="number" name="qty[]" class="input-qty w-full rounded-lg border-gray-300 px-3 py-2 text-center focus:border-purple-500 focus:ring-purple-200" min="1" value="1" required>
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
                            <td colspan="3" class="px-4 py-3 text-right font-bold text-purple-700">GRAND TOTAL:</td>
                            <td colspan="2" class="px-4 py-3">
                                <input type="text" id="grand_total" class="w-full rounded-lg border-gray-200 bg-white px-3 py-2 text-right text-lg font-bold text-green-700" readonly>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <button type="button" id="tambahBaris" class="text-sm font-medium text-purple-600 hover:text-purple-700">
                + Tambah Baris Barang
            </button>
        </div>

        <div class="flex items-center gap-3 border-t border-purple-50 pt-5">
            <x-button type="submit" variant="success">Simpan & Proses Barang Masuk</x-button>
            <x-button as="a" href="{{ route('pembelian.index') }}" variant="ghost">Batal</x-button>
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

    // Hitung semua total
    function hitungSemuaTotal() {
        let totalKeseluruhan = 0;
        daftarBarang.querySelectorAll('tr').forEach(baris => {
            const harga = parseFloat(baris.querySelector('.input-harga').value) || 0;
            const qty = parseFloat(baris.querySelector('.input-qty').value) || 0;
            const subtotal = harga * qty;
            baris.querySelector('.input-subtotal').value = `Rp ${subtotal.toLocaleString('id-ID')}`;
            totalKeseluruhan += subtotal;
        });
        inputGrandTotal.value = `Rp ${totalKeseluruhan.toLocaleString('id-ID')}`;
    }

    // Pasang event ke satu baris
    function pasangEventBaris(baris) {
        // Isi harga otomatis
        const selectBarang = baris.querySelector('.select-barang');
        const inputHarga = baris.querySelector('.input-harga');
        selectBarang.addEventListener('change', function() {
            const harga = this.selectedOptions[0]?.dataset.harga || 0;
            inputHarga.value = harga;
            hitungSemuaTotal();
        });

        // Hitung ulang saat ubah nilai
        inputHarga.addEventListener('input', hitungSemuaTotal);
        baris.querySelector('.input-qty').addEventListener('input', hitungSemuaTotal);

        // Hapus baris
        baris.querySelector('.hapus-baris').addEventListener('click', function() {
            if (daftarBarang.rows.length > 1) {
                baris.remove();
                hitungSemuaTotal();
            } else {
                alert('Minimal harus ada 1 barang untuk dibeli!');
            }
        });
    }

    // Inisialisasi baris pertama
    pasangEventBaris(daftarBarang.rows[0]);
    hitungSemuaTotal();

    // Tambah baris baru
    tombolTambah.addEventListener('click', function() {
        const barisPertama = daftarBarang.rows[0];
        const barisBaru = barisPertama.cloneNode(true);
        
        barisBaru.querySelector('.select-barang').value = '';
        barisBaru.querySelector('.input-harga').value = '';
        barisBaru.querySelector('.input-qty').value = '1';
        barisBaru.querySelector('.input-subtotal').value = '';
        
        daftarBarang.appendChild(barisBaru);
        pasangEventBaris(barisBaru);
    });
});
</script>
@endsection