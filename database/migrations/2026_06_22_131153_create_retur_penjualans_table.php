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
        Schema::create('retur_penjualans', function (Blueprint $table) {
            $table->id();
            $table->string('no_retur')->unique();
            $table->date('tgl_retur');
            $table->foreignId('penjualan_id')->constrained('penjualans');
            $table->foreignId('konsumen_id')->constrained('konsumens');
            $table->text('alasan');
            $table->integer('total_retur');
            $table->timestamps();
        });

        Schema::create('retur_penjualan_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('retur_penjualan_id')->constrained('retur_penjualans')->onDelete('cascade');
            $table->foreignId('barang_id')->constrained('barangs');
            $table->integer('qty');
            $table->integer('harga_satuan');
            $table->integer('subtotal');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('retur_penjualan_details');
        Schema::dropIfExists('retur_penjualans');
    }
};
