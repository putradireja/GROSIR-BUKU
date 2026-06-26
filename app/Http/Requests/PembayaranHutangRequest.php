<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PembayaranHutangRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'no_bayar' => 'required|string|unique:pembayaran_hutangs,no_bayar',
            'tgl_bayar' => 'required|date',
            'pembelian_id' => 'required|exists:pembelians,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'total_hutang' => 'required|numeric|min:0',
            'jumlah_bayar' => 'required|numeric|min:1',
            'ket' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'pembelian_id.required' => 'Pilih transaksi pembelian terlebih dahulu.',
            'jumlah_bayar.required' => 'Jumlah bayar wajib diisi.',
            'jumlah_bayar.min' => 'Jumlah bayar minimal adalah 1.',
        ];
    }
}