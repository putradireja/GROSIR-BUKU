<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BarangRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        $barangId = $this->route('barang') ? $this->route('barang')->id : null;

        return [
            'kode' => 'required|string|max:50|unique:barangs,kode,' . $barangId,
            'judul' => 'required|string|max:255',
            'pengarang' => 'required|string|max:255',
            'penerbit' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'harga_beli' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'kode.required' => 'Kode Barang wajib diisi.',
            'kode.unique' => 'Kode Barang sudah terdaftar.',
            'judul.required' => 'Judul Buku wajib diisi.',
            'pengarang.required' => 'Nama Pengarang wajib diisi.',
            'penerbit.required' => 'Nama Penerbit wajib diisi.',
            'kategori.required' => 'Kategori wajib diisi.',
            'harga_beli.required' => 'Harga Beli wajib diisi.',
            'harga_beli.numeric' => 'Harga Beli harus berupa angka.',
            'harga_jual.required' => 'Harga Jual wajib diisi.',
            'harga_jual.numeric' => 'Harga Jual harus berupa angka.',
            'stok.required' => 'Stok wajib diisi.',
            'stok.integer' => 'Stok harus berupa angka bulat.',
        ];
    }
}