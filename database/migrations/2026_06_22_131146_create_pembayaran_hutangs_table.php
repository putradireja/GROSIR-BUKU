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
        Schema::create('pembayaran_hutangs', function (Blueprint $table) {
            $table->id();
            $table->string('no_bayar')->unique();
            $table->date('tgl_bayar');
            $table->foreignId('pembelian_id')->constrained('pembelians');
            $table->foreignId('supplier_id')->constrained('suppliers');
            $table->integer('total_hutang');
            $table->integer('jumlah_bayar');
            $table->integer('sisa_hutang');
            $table->text('ket')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran_hutangs');
    }
};
