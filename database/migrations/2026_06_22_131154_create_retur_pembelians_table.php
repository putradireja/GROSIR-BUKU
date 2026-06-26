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
        Schema::create('retur_pembelians', function (Blueprint $table) {
            $table->id();
            $table->string('no_retur')->unique();
            $table->date('tgl_retur');
            $table->foreignId('pembelian_id')->constrained('pembelians');
            $table->foreignId('supplier_id')->constrained('suppliers');
            $table->text('alasan');
            $table->integer('total_retur');
            $table->timestamps();
        });

        Schema::create('retur_pembelian_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('retur_pembelian_id')->constrained('retur_pembelians')->onDelete('cascade');
            $table->foreignId('barang_id')->constrained('barangs');
            $table->integer('qty');
            $table->integer('harga_satuan');
            $table->integer('subtotal');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('retur_pembelian_details');
        Schema::dropIfExists('retur_pembelians');
    }
};
