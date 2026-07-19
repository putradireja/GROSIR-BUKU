@extends('layouts.app')

@section('title', 'Form Terima Pembayaran Piutang')

@section('content')
<x-card title="Form Terima Pembayaran Piutang" subtitle="Pencatatan pembayaran cicilan atau pelunasan piutang konsumen">
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

    <form action="{{ route('penagihan.store') }}" method="POST" class="space-y-5">
        @csrf
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
            <div>
                <x-input-label for="no_tagih" value="No. Tanda Terima" />
                <x-text-input id="no_tagih" name="no_tagih" class="mt-1.5 bg-gray-50 text-gray-600" value="{{ $no_tagih }}" readonly />
            </div>

            <div>
                <x-input-label for="tgl_tagih" value="Tanggal Pembayaran" />
                <x-text-input id="tgl_tagih" type="date" name="tgl_tagih" class="mt-1.5" value="{{ date('Y-m-d') }}" required />
            </div>

            <div class="lg:col-span-3">
                <x-input-label for="select_penjualan" value="Pilih Transaksi Penjualan Kredit" />
                <select id="select_penjualan" name="penjualan_id" class="mt-1.5 w-full rounded-lg border-gray-300 focus:border-purple-500 focus:ring-purple-200" required>
                    <option value="">-- Pilih Nomor Penjualan --</option>
                    @foreach($penjualans as $pj)
                        <option value="{{ $pj->id }}" 
                                data-konsumen-id="{{ $pj->konsumen_id }}" 
                                data-konsumen-nama="{{ $pj->konsumen->nama }}"
                                data-sisa="{{ $pj->sisa_piutang }}">
                            {{ $pj->no_jual }} - {{ $pj->konsumen->nama }} (Sisa: Rp {{ number_format($pj->sisa_piutang, 0, ',', '.') }})
                        </option>
                    @endforeach
                </select>
            </div>

            <input type="hidden" name="konsumen_id" id="konsumen_id">

            <div>
                <x-input-label for="konsumen_nama" value="Nama Konsumen" />
                <x-text-input id="konsumen_nama" class="mt-1.5 bg-gray-50 text-gray-600" readonly />
            </div>

            <div>
                <x-input-label for="total_piutang" value="Total Sisa Piutang (Rp)" />
                <x-text-input id="total_piutang" name="total_piutang" type="number" class="mt-1.5 bg-gray-50 text-gray-600" readonly required />
            </div>

            <div>
                <x-input-label for="jumlah_bayar" value="Jumlah Bayar Diterima (Rp)" />
                <x-text-input id="jumlah_bayar" name="jumlah_bayar" type="number" class="mt-1.5 font-bold text-green-600" min="1" required />
            </div>

            <div class="lg:col-span-3">
                <x-input-label for="ket" value="Keterangan / Catatan" />
                <textarea id="ket" name="ket" rows="2" class="mt-1.5 w-full rounded-lg border-gray-300 focus:border-purple-500 focus:ring-purple-200" placeholder="Contoh: Pembayaran cicilan ke-1 / Lunas via Transfer BCA"></textarea>
            </div>
        </div>

        <div class="flex items-center gap-3 border-t border-purple-50 pt-5">
            <x-button type="submit" variant="primary">Simpan Pembayaran</x-button>
            <x-button as="a" href="{{ route('penagihan.index') }}" variant="ghost">Batal</x-button>
        </div>
    </form>
</x-card>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectPenjualan = document.getElementById('select_penjualan');
    const inputKonsumenId = document.getElementById('konsumen_id');
    const inputKonsumenNama = document.getElementById('konsumen_nama');
    const inputTotalPiutang = document.getElementById('total_piutang');
    const inputJumlahBayar = document.getElementById('jumlah_bayar');

    selectPenjualan.addEventListener('change', function() {
        const selected = this.selectedOptions[0];
        
        if (this.value) {
            const sisa = selected.dataset.sisa;
            
            inputKonsumenId.value = selected.dataset.konsumenId;
            inputKonsumenNama.value = selected.dataset.konsumenNama;
            inputTotalPiutang.value = sisa;
            
            inputJumlahBayar.setAttribute('max', sisa);
            inputJumlahBayar.value = sisa;
        } else {
            inputKonsumenId.value = '';
            inputKonsumenNama.value = '';
            inputTotalPiutang.value = '';
            inputJumlahBayar.removeAttribute('max');
            inputJumlahBayar.value = '';
        }
    });
});
</script>
@endsection