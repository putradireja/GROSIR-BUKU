<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Barang;

class BarangSeeder extends Seeder
{
    public function run(): void
    {
        $barangs = [
            ['kode' => 'B-001', 'judul' => 'Atomic Habits', 'pengarang' => 'James Clear', 'penerbit' => 'Gramedia', 'kategori' => 'Pengembangan Diri', 'harga_beli' => 70000, 'harga_jual' => 108000, 'stok' => 50],
            ['kode' => 'B-002', 'judul' => 'Bumi Manusia', 'pengarang' => 'Pramoedya Ananta Toer', 'penerbit' => 'Lentera Dipantara', 'kategori' => 'Novel', 'harga_beli' => 85000, 'harga_jual' => 120000, 'stok' => 35],
            ['kode' => 'B-003', 'judul' => 'Filosofi Teras', 'pengarang' => 'Henry Manampiring', 'penerbit' => 'Kompas', 'kategori' => 'Filsafat', 'harga_beli' => 65000, 'harga_jual' => 98000, 'stok' => 40],
            ['kode' => 'B-004', 'judul' => 'Pemrograman Laravel 12', 'pengarang' => 'Budi Raharjo', 'penerbit' => 'Informatika', 'kategori' => 'Komputer', 'harga_beli' => 90000, 'harga_jual' => 135000, 'stok' => 20],
            ['kode' => 'B-005', 'judul' => 'Laskar Pelangi', 'pengarang' => 'Andrea Hirata', 'penerbit' => 'Bentang Pustaka', 'kategori' => 'Novel', 'harga_beli' => 55000, 'harga_jual' => 85000, 'stok' => 60],
            ['kode' => 'B-006', 'judul' => 'Sapiens: Riwayat Singkat Umat Manusia', 'pengarang' => 'Yuval Noah Harari', 'penerbit' => 'KPG', 'kategori' => 'Sejarah', 'harga_beli' => 80000, 'harga_jual' => 115000, 'stok' => 25],
            ['kode' => 'B-007', 'judul' => 'Rich Dad Poor Dad', 'pengarang' => 'Robert T. Kiyosaki', 'penerbit' => 'Gramedia', 'kategori' => 'Bisnis', 'harga_beli' => 45000, 'harga_jual' => 75000, 'stok' => 45],
            ['kode' => 'B-008', 'judul' => 'Laut Bercerita', 'pengarang' => 'Leila S. Chudori', 'penerbit' => 'KPG', 'kategori' => 'Novel', 'harga_beli' => 75000, 'harga_jual' => 110000, 'stok' => 55],
            ['kode' => 'B-009', 'judul' => 'Cantik Itu Luka', 'pengarang' => 'Eka Kurniawan', 'penerbit' => 'Gramedia', 'kategori' => 'Novel', 'harga_beli' => 85000, 'harga_jual' => 125000, 'stok' => 30],
            ['kode' => 'B-010', 'judul' => 'Python for Data Analysis', 'pengarang' => 'Wes McKinney', 'penerbit' => 'O\'Reilly', 'kategori' => 'Komputer', 'harga_beli' => 150000, 'harga_jual' => 220000, 'stok' => 15],
            ['kode' => 'B-011', 'judul' => 'Sebuah Seni Bersikap Bodo Amat', 'pengarang' => 'Mark Manson', 'penerbit' => 'Grasindo', 'kategori' => 'Pengembangan Diri', 'harga_beli' => 55000, 'harga_jual' => 85000, 'stok' => 70],
            ['kode' => 'B-012', 'judul' => 'Mastering React JS', 'pengarang' => 'Alex Banks', 'penerbit' => 'Andi Publisher', 'kategori' => 'Komputer', 'harga_beli' => 110000, 'harga_jual' => 160000, 'stok' => 10],
            ['kode' => 'B-013', 'judul' => 'Sejarah Tuhan', 'pengarang' => 'Karen Armstrong', 'penerbit' => 'Mizan', 'kategori' => 'Agama / Filsafat', 'harga_beli' => 95000, 'harga_jual' => 140000, 'stok' => 22],
            ['kode' => 'B-014', 'judul' => 'Bicara Itu Ada Seninya', 'pengarang' => 'Oh Su Hyang', 'penerbit' => 'Bhuana Ilmu Populer', 'kategori' => 'Pengembangan Diri', 'harga_beli' => 50000, 'harga_jual' => 78000, 'stok' => 38],
            ['kode' => 'B-015', 'judul' => 'Kamus Inggris - Indonesia', 'pengarang' => 'John M. Echols', 'penerbit' => 'Gramedia', 'kategori' => 'Pendidikan', 'harga_beli' => 100000, 'harga_jual' => 145000, 'stok' => 80],
            ['kode' => 'B-016', 'judul' => 'Buku Pintar CPNS 2026', 'pengarang' => 'Tim Master Edukasi', 'penerbit' => 'Bintang Wahyu', 'kategori' => 'Pendidikan', 'harga_beli' => 120000, 'harga_jual' => 165000, 'stok' => 40],
            ['kode' => 'B-017', 'judul' => 'Dunia Sophie', 'pengarang' => 'Jostein Gaarder', 'penerbit' => 'Mizan', 'kategori' => 'Filsafat', 'harga_beli' => 80000, 'harga_jual' => 115000, 'stok' => 28],
            ['kode' => 'B-018', 'judul' => 'Ronggeng Dukuh Paruk', 'pengarang' => 'Ahmad Tohari', 'penerbit' => 'Gramedia', 'kategori' => 'Novel', 'harga_beli' => 60000, 'harga_jual' => 90000, 'stok' => 32],
            ['kode' => 'B-019', 'judul' => 'Belajar Jaringan Komputer', 'pengarang' => 'Melwin Syafrizal', 'penerbit' => 'Andi Publisher', 'kategori' => 'Komputer', 'harga_beli' => 70000, 'harga_jual' => 105000, 'stok' => 18],
            ['kode' => 'B-020', 'judul' => 'Garis Waktu', 'pengarang' => 'Fiersa Besari', 'penerbit' => 'Mediakita', 'kategori' => 'Novel', 'harga_beli' => 55000, 'harga_jual' => 88000, 'stok' => 50],
        ];

        foreach ($barangs as $barang) {
            Barang::create($barang);
        }
    }
}