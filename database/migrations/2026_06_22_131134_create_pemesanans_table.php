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
        Schema::create('pemesanans', function (Blueprint $table) {
            $table->id();
            $table->string('no_pesan')->unique();
            $table->date('tgl_pesan');
            $table->foreignId('supplier_id')->constrained('suppliers');
            $table->enum('status', ['pending', 'approved', 'cancelled'])->default('pending');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });

        Schema::create('pemesanan_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pemesanan_id')->constrained('pemesanans')->onDelete('cascade');
            $table->foreignId('barang_id')->constrained('barangs');
            $table->integer('qty');
            $table->integer('harga_satuan');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pemesanan_details');
        Schema::dropIfExists('pemesanans');
    }
};
