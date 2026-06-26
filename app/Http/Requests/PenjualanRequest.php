<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PenjualanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'no_jual' => 'required|string|unique:penjualans,no_jual',
            'tgl_jual' => 'required|date',
            'konsumen_id' => 'required|exists:konsumens,id',
            'tipe' => 'required|in:cash,credit',
            'jatuh_tempo' => 'nullable|required_if:tipe,credit|date',
            'barang_id' => 'required|array|min:1',
            'barang_id.*' => 'required|exists:barangs,id',
            'qty' => 'required|array|min:1',
            'qty.*' => 'required|integer|min:1',
            'harga_satuan' => 'required|array|min:1',
            'harga_satuan.*' => 'required|numeric|min:0',
            'diskon' => 'array',
            'diskon.*' => 'nullable|numeric|min:0',
        ];
    }
    
    public function messages(): array
    {
        return [
            'jatuh_tempo.required_if' => 'Tanggal jatuh tempo wajib diisi untuk penjualan Credit.',
            'barang_id.required' => 'Minimal satu barang harus ditambahkan ke keranjang.',
        ];
    }
}