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
            $table->foreignId('pasien_id')->nullable()->after('id')->constrained('pasiens')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('riwayat_konsultasis', function (Blueprint $table) {
            $table->dropForeign(['pasien_id']);
            $table->dropColumn('pasien_id');
        });
    }
};
