<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Supplier;

class SupplierSeeder extends Seeder
{
    public function run(): void
    {
        $suppliers = [
            ['kode' => 'SUP-001', 'nama' => 'PT Gramedia Pustaka', 'alamat' => 'Jl. Palmerah Barat No. 29, Jakarta', 'telepon' => '021-53650110', 'email' => 'info@gramedia.com'],
            ['kode' => 'SUP-002', 'nama' => 'Penerbit Erlangga', 'alamat' => 'Jl. H. Baping Raya No. 100, Jakarta', 'telepon' => '021-8717006', 'email' => 'cs@erlangga.co.id'],
            ['kode' => 'SUP-003', 'nama' => 'Mizan Publika', 'alamat' => 'Jl. Cinambo No. 135, Bandung', 'telepon' => '022-7834310', 'email' => 'redaksi@mizan.com'],
            ['kode' => 'SUP-004', 'nama' => 'Bentang Pustaka', 'alamat' => 'Jl. Pesanggrahan No. 8, Yogyakarta', 'telepon' => '0274-580839', 'email' => 'promosi@bentangpustaka.com'],
            ['kode' => 'SUP-005', 'nama' => 'Penerbit Andi', 'alamat' => 'Jl. Beo No. 38, Yogyakarta', 'telepon' => '0274-561881', 'email' => 'info@andipublisher.com'],
            ['kode' => 'SUP-006', 'nama' => 'Informatika Bandung', 'alamat' => 'Jl. Buah Batu No. 101, Bandung', 'telepon' => '022-7315604', 'email' => 'order@informatika.co.id'],
            ['kode' => 'SUP-007', 'nama' => 'Republika Penerbit', 'alamat' => 'Jl. Kav. Polri Blok G No. 29, Jakarta', 'telepon' => '021-7819127', 'email' => 'redaksi@bukurepublika.id'],
            ['kode' => 'SUP-008', 'nama' => 'Elex Media Komputindo', 'alamat' => 'Gedung Kompas Gramedia, Jakarta', 'telepon' => '021-53650111', 'email' => 'elex.media@gramedia.com'],
            ['kode' => 'SUP-009', 'nama' => 'Pustaka Al-Kautsar', 'alamat' => 'Jl. Cipinang Muara Raya, Jakarta', 'telepon' => '021-8507590', 'email' => 'alkautsar@yahoo.com'],
            ['kode' => 'SUP-010', 'nama' => 'GagasMedia', 'alamat' => 'Jl. H. Montong No. 57, Ciganjur', 'telepon' => '021-78883030', 'email' => 'redaksi@gagasmedia.net'],
        ];

        foreach ($suppliers as $supplier) {
            Supplier::create($supplier);
        }
    }
}