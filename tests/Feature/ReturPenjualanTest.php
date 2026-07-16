<?php

namespace Tests\Feature;

use App\Models\Barang;
use App\Models\Konsumen;
use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ReturPenjualanTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_store_retur_penjualan(): void
    {
        $user = User::create([
            'name' => 'Kasir Test',
            'email' => 'kasir@test.com',
            'password' => Hash::make('password'),
        ]);
        $supplier = Supplier::create([
            'kode' => 'SP-001',
            'nama' => 'Supplier A',
            'alamat' => 'Jakarta',
            'telepon' => '08123456789',
            'email' => 'supplier@example.com',
        ]);
        $konsumen = Konsumen::create([
            'kode' => 'KS-001',
            'nama' => 'Konsumen A',
            'alamat' => 'Bandung',
            'telepon' => '081122334455',
            'email' => 'konsumen@example.com',
        ]);
        $barang = Barang::create([
            'kode' => 'B001',
            'judul' => 'Buku Test',
            'pengarang' => 'Pengarang',
            'penerbit' => 'Penerbit',
            'kategori' => 'Umum',
            'harga_beli' => 5000,
            'harga_jual' => 7000,
            'stok' => 10,
        ]);

        $penjualan = Penjualan::create([
            'no_jual' => 'J001',
            'tgl_jual' => now()->toDateString(),
            'konsumen_id' => $konsumen->id,
            'tipe' => 'cash',
            'jatuh_tempo' => null,
            'supplier_id' => $supplier->id,
            'status_bayar' => 'lunas',
            'total' => 7000,
        ]);

        PenjualanDetail::create([
            'penjualan_id' => $penjualan->id,
            'barang_id' => $barang->id,
            'qty' => 1,
            'harga_satuan' => 7000,
            'diskon' => 0,
            'subtotal' => 7000,
        ]);

        $response = $this->actingAs($user)->post(route('retur-penjualan.store'), [
            'no_retur' => 'RB-'.now()->format('Ymd').'-001',
            'tgl_retur' => now()->toDateString(),
            'penjualan_id' => $penjualan->id,
            'supplier_id' => $supplier->id,
            'keterangan' => 'Barang rusak',
            'barang_id' => [$barang->id],
            'qty' => [1],
        ]);

        $response->assertRedirect(route('retur-penjualan.index'));
        $this->assertDatabaseHas('retur_penjualans', ['penjualan_id' => $penjualan->id]);
    }
}
