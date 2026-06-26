<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Konsumen;

class KonsumenSeeder extends Seeder
{
    public function run(): void
    {
        $konsumens = [
            ['kode' => 'KUS-001', 'nama' => 'Toko Buku Togamas', 'alamat' => 'Jl. Supratman No. 45, Bandung', 'telepon' => '081234567890', 'email' => 'togamas.bdg@example.com'],
            ['kode' => 'KUS-002', 'nama' => 'Gunung Agung Store', 'alamat' => 'Jl. Kwitang No. 38, Jakarta', 'telepon' => '081987654321', 'email' => 'gunungagung@example.com'],
            ['kode' => 'KUS-003', 'nama' => 'Koperasi Mahasiswa ITB', 'alamat' => 'Jl. Ganesha No. 10, Bandung', 'telepon' => '085511223344', 'email' => 'kopma@itb.ac.id'],
            ['kode' => 'KUS-004', 'nama' => 'Gramedia Merdeka', 'alamat' => 'Jl. Merdeka No. 43, Bandung', 'telepon' => '022-4231221', 'email' => 'gm.merdeka@gramedia.com'],
            ['kode' => 'KUS-005', 'nama' => 'Toko Buku Salemba', 'alamat' => 'Jl. Salemba Raya No. 4, Jakarta', 'telepon' => '021-3144669', 'email' => 'salemba.store@example.com'],
            ['kode' => 'KUS-006', 'nama' => 'Perpustakaan Nasional RI', 'alamat' => 'Jl. Medan Merdeka Selatan No. 11, Jakarta', 'telepon' => '081199887766', 'email' => 'pengadaan@perpusnas.go.id'],
            ['kode' => 'KUS-007', 'nama' => 'Koperasi UNPAD', 'alamat' => 'Kampus Jatinangor, Sumedang', 'telepon' => '082233445566', 'email' => 'kopma@unpad.ac.id'],
            ['kode' => 'KUS-008', 'nama' => 'Toko Buku Wali Songo', 'alamat' => 'Jl. Kwitang Raya, Jakarta', 'telepon' => '021-31931112', 'email' => 'walisongo.book@example.com'],
            ['kode' => 'KUS-009', 'nama' => 'Kios Buku Palasari', 'alamat' => 'Pasar Buku Palasari, Bandung', 'telepon' => '081344556677', 'email' => 'palasari.buku@example.com'],
            ['kode' => 'KUS-010', 'nama' => 'Social Agency Baru', 'alamat' => 'Jl. Kaliurang KM.8, Yogyakarta', 'telepon' => '0274-884323', 'email' => 'social.agency@example.com'],
        ];

        foreach ($konsumens as $konsumen) {
            Konsumen::create($konsumen);
        }
    }
}