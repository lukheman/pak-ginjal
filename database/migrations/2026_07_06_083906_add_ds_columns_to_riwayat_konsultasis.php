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
        Schema::table('riwayat_konsultasis', function (Blueprint $table) {
            $table->foreignId('hasil_penyakit_ds_id')->nullable()->after('nilai_cf')->constrained('penyakit')->nullOnDelete();
            $table->float('nilai_ds')->nullable()->after('hasil_penyakit_ds_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('riwayat_konsultasis', function (Blueprint $table) {
            $table->dropForeign(['hasil_penyakit_ds_id']);
            $table->dropColumn(['hasil_penyakit_ds_id', 'nilai_ds']);
        });
    }
};
