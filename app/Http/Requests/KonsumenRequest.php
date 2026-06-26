<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KonsumenRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        // Mengambil ID dari parameter route yang disingularkan oleh Laravel ('konsuman')
        $konsumenId = $this->route('konsuman');

        // Jika formatnya berupa object (Model), ambil field 'id'-nya
        // Jika sudah berupa angka/string ID (karena perbaikan Controller kita sebelumnya), langsung gunakan.
        if (is_object($konsumenId)) {
            $konsumenId = $konsumenId->id;
        }

        return [
            // Pengecualian ID sekarang akan berjalan normal!
            'kode' => 'required|string|max:50|unique:konsumens,kode,' . $konsumenId,
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'telepon' => 'required|string|max:20',
            'email' => 'required|email|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'kode.required' => 'Kode Konsumen wajib diisi.',
            'kode.unique' => 'Kode Konsumen sudah terdaftar.',
            'nama.required' => 'Nama Konsumen wajib diisi.',
            'alamat.required' => 'Alamat wajib diisi.',
            'telepon.required' => 'Nomor Telepon wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
        ];
    }
}