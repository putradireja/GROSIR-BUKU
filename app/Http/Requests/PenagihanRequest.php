<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PenagihanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'no_tagih' => 'required|string|unique:penagihans,no_tagih',
            'tgl_tagih' => 'required|date',
            'penjualan_id' => 'required|exists:penjualans,id',
            'konsumen_id' => 'required|exists:konsumens,id',
            'total_piutang' => 'required|numeric|min:0',
            'jumlah_bayar' => 'required|numeric|min:1',
            'ket' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'penjualan_id.required' => 'Pilih transaksi penjualan terlebih dahulu.',
            'jumlah_bayar.required' => 'Jumlah bayar wajib diisi.',
            'jumlah_bayar.min' => 'Jumlah bayar minimal adalah 1.',
        ];
    }
}