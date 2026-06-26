<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Buat tabel induk (Pembelian)
        Schema::create('pembelians', function (Blueprint $table) {
            $table->id();
            $table->string('no_beli')->unique();
            $table->date('tgl_beli');
            $table->foreignId('pemesanan_id')->nullable()->constrained('pemesanans')->onDelete('set null');
            $table->enum('tipe', ['cash', 'credit']);
            $table->foreignId('supplier_id')->constrained('suppliers')->onDelete('cascade');
            $table->date('jatuh_tempo')->nullable();
            $table->enum('status_bayar', ['lunas', 'belum'])->default('belum');
            $table->integer('total')->default(0);
            $table->timestamps();
        });

        // 2. Buat tabel detailnya (Pembelian Detail)
        Schema::create('pembelian_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pembelian_id')->constrained('pembelians')->onDelete('cascade');
            $table->foreignId('barang_id')->constrained('barangs')->onDelete('cascade');
            $table->integer('qty');
            $table->integer('harga_satuan');
            $table->integer('subtotal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembelian_details');
        Schema::dropIfExists('pembelians');
    }
};