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
        Schema::table('pasiens', function (Blueprint $table) {
            $table->dropColumn('umur');
            $table->date('tanggal_lahir')->nullable();
            $table->string('tempat_lahir')->nullable();
        });

        Schema::table('riwayat_konsultasis', function (Blueprint $table) {
            $table->dropColumn('umur');
            $table->date('tanggal_lahir')->nullable();
            $table->string('tempat_lahir')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pasiens', function (Blueprint $table) {
            $table->integer('umur')->nullable();
            $table->dropColumn(['tanggal_lahir', 'tempat_lahir']);
        });

        Schema::table('riwayat_konsultasis', function (Blueprint $table) {
            $table->integer('umur')->nullable();
            $table->dropColumn(['tanggal_lahir', 'tempat_lahir']);
        });
    }
};
