<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ReturPenjualanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'no_retur' => 'required|string|unique:retur_penjualans,no_retur',
            'tgl_retur' => 'required|date',
            'penjualan_id' => 'required|exists:penjualans,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
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
            'penjualan_id.required' => 'Pilih Referensi Penjualan terlebih dahulu.',
            'barang_id.required' => 'Minimal satu barang harus dipilih untuk diretur.',
        ];
    }
}
