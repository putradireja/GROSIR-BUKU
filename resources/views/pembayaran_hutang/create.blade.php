@extends('layouts.app')

@section('title', 'Form Pembayaran Hutang Supplier')

@section('content')
<x-card title="Form Pembayaran Hutang Supplier" subtitle="Pencatatan pembayaran cicilan atau pelunasan hutang ke pemasok">
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

    <form action="{{ route('pembayaran-hutang.store') }}" method="POST" class="space-y-5">
        @csrf
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
            <div>
                <x-input-label for="no_bayar" value="No. Bukti Bayar" />
                <x-text-input id="no_bayar" name="no_bayar" class="mt-1.5 bg-gray-50 text-gray-600" value="{{ $no_bayar }}" readonly />
            </div>

            <div>
                <x-input-label for="tgl_bayar" value="Tanggal Pembayaran" />
                <x-text-input id="tgl_bayar" type="date" name="tgl_bayar" class="mt-1.5" value="{{ date('Y-m-d') }}" required />
            </div>

            <div class="lg:col-span-3">
                <x-input-label for="select_pembelian" value="Pilih Transaksi Pembelian Kredit" />
                <select id="select_pembelian" name="pembelian_id" class="mt-1.5 w-full rounded-lg border-gray-300 focus:border-purple-500 focus:ring-purple-200" required>
                    <option value="">-- Pilih Nomor Pembelian --</option>
                    @foreach($pembelians as $pb)
                        <option value="{{ $pb->id }}" 
                                data-supplier-id="{{ $pb->supplier_id }}" 
                                data-supplier-nama="{{ $pb->supplier->nama }}"
                                data-sisa="{{ $pb->sisa_hutang }}">
                            {{ $pb->no_beli }} - {{ $pb->supplier->nama }} (Sisa: Rp {{ number_format($pb->sisa_hutang, 0, ',', '.') }})
                        </option>
                    @endforeach
                </select>
            </div>

            <input type="hidden" name="supplier_id" id="supplier_id">

            <div>
                <x-input-label for="supplier_nama" value="Nama Supplier" />
                <x-text-input id="supplier_nama" class="mt-1.5 bg-gray-50 text-gray-600" readonly />
            </div>

            <div>
                <x-input-label for="total_hutang" value="Total Sisa Hutang (Rp)" />
                <x-text-input id="total_hutang" name="total_hutang" type="number" class="mt-1.5 bg-gray-50 text-gray-600" readonly required />
            </div>

            <div>
                <x-input-label for="jumlah_bayar" value="Jumlah Bayar Keluar (Rp)" />
                <x-text-input id="jumlah_bayar" name="jumlah_bayar" type="number" class="mt-1.5 font-bold text-purple-600" min="1" required />
            </div>

            <div class="lg:col-span-3">
                <x-input-label for="ket" value="Keterangan / Catatan" />
                <textarea id="ket" name="ket" rows="2" class="mt-1.5 w-full rounded-lg border-gray-300 focus:border-purple-500 focus:ring-purple-200" placeholder="Contoh: Pembayaran termin 1 / Lunas via Bank Mandiri"></textarea>
            </div>
        </div>

        <div class="flex items-center gap-3 border-t border-purple-50 pt-5">
            <x-button type="submit" variant="primary">Proses Pembayaran</x-button>
            <x-button as="a" href="{{ route('pembayaran-hutang.index') }}" variant="ghost">Batal</x-button>
        </div>
    </form>
</x-card>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectPembelian = document.getElementById('select_pembelian');
    const inputSupplierId = document.getElementById('supplier_id');
    const inputSupplierNama = document.getElementById('supplier_nama');
    const inputTotalHutang = document.getElementById('total_hutang');
    const inputJumlahBayar = document.getElementById('jumlah_bayar');

    selectPembelian.addEventListener('change', function() {
        const selected = this.selectedOptions[0];
        
        if (this.value) {
            const sisa = selected.dataset.sisa;
            
            inputSupplierId.value = selected.dataset.supplierId;
            inputSupplierNama.value = selected.dataset.supplierNama;
            inputTotalHutang.value = sisa;
            
            inputJumlahBayar.setAttribute('max', sisa);
            inputJumlahBayar.value = sisa;
        } else {
            inputSupplierId.value = '';
            inputSupplierNama.value = '';
            inputTotalHutang.value = '';
            inputJumlahBayar.removeAttribute('max');
            inputJumlahBayar.value = '';
        }
    });
});
</script>
@endsection