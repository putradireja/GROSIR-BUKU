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
        Schema::create('penjualans', function (Blueprint $table) {
            $table->id();
            $table->string('no_jual')->unique();
            $table->date('tgl_jual');
            $table->foreignId('konsumen_id')->constrained('konsumens');
            $table->enum('tipe', ['cash', 'credit']);
            $table->date('jatuh_tempo')->nullable();
            $table->foreignId('supplier_id')->constrained('suppliers')->onDelete('cascade');
            $table->enum('status_bayar', ['lunas', 'belum'])->default('belum');
            $table->integer('total');
            $table->timestamps();
        });

        Schema::create('penjualan_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penjualan_id')->constrained('penjualans')->onDelete('cascade');
            $table->foreignId('barang_id')->constrained('barangs');
            $table->integer('qty');
            $table->integer('harga_satuan');
            $table->integer('diskon')->default(0);
            $table->integer('subtotal');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penjualan_details');
        Schema::dropIfExists('penjualans');
    }
};
