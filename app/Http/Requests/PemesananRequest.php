<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PemesananRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'no_pesan' => 'required|string|unique:pemesanans,no_pesan',
            'tgl_pesan' => 'required|date',
            'supplier_id' => 'required|exists:suppliers,id',
            'catatan' => 'nullable|string',
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
            'no_pesan.unique' => 'Nomor Pesanan sudah ada!',
            'barang_id.required' => 'Minimal satu barang harus ditambahkan.',
            'qty.*.min' => 'Quantity minimal 1.',
        ];
    }
}