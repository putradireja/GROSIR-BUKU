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
        Schema::table('retur_penjualans', function (Blueprint $table) {
            if (! Schema::hasColumn('retur_penjualans', 'supplier_id')) {
                $table->foreignId('supplier_id')->nullable()->after('penjualan_id')->constrained('suppliers');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('retur_penjualans', function (Blueprint $table) {
            if (Schema::hasColumn('retur_penjualans', 'supplier_id')) {
                $table->dropForeign(['supplier_id']);
                $table->dropColumn('supplier_id');
            }
        });
    }
};
