<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PembelianRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'no_beli' => 'required|string|unique:pembelians,no_beli',
            'tgl_beli' => 'required|date',
            'tipe' => 'required|in:cash,credit',
            'jatuh_tempo' => 'nullable|required_if:tipe,credit|date',
            'supplier_id' => 'required|exists:suppliers,id',
            'pemesanan_id' => 'nullable|exists:pemesanans,id',
            'barang_id' => 'required|array|min:1',
            'barang_id.*' => 'required|exists:barangs,id',
            'qty' => 'required|array|min:1',
            'qty.*' => 'required|integer|min:1',
            'harga_satuan' => 'required|array|min:1',
            'harga_satuan.*' => 'required|numeric|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'jatuh_tempo.required_if' => 'Tanggal jatuh tempo wajib diisi jika tipe pembayaran Credit.',
            'barang_id.required' => 'Minimal satu barang harus ditambahkan.',
        ];
    }
}