<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReturPembelianRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'no_retur' => 'required|string|unique:retur_pembelians,no_retur',
            'tgl_retur' => 'required|date',
            'pembelian_id' => 'required|exists:pembelians,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'keterangan' => 'nullable|string',
            'barang_id' => 'required|array|min:1',
            'barang_id.*' => 'required|exists:barangs,id',
            'qty' => 'required|array|min:1',
            'qty.*' => 'required|integer|min:1',
        ];
    }

    public function messages(): array
    {
        return [
            'pembelian_id.required' => 'Pilih Referensi Pembelian terlebih dahulu.',
            'barang_id.required' => 'Minimal satu barang harus dipilih untuk diretur.',
        ];
    }
}