<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Drop empty old unused tables if they exist
        if (Schema::hasTable('gejala') && DB::table('gejala')->count() == 0) {
            Schema::dropIfExists('gejala');
        }
        if (Schema::hasTable('basis_pengetahuan') && DB::table('basis_pengetahuan')->count() == 0) {
            Schema::dropIfExists('basis_pengetahuan');
        }

        // Rename plural tables to singular
        if (Schema::hasTable('pasiens') && !Schema::hasTable('pasien')) {
            Schema::rename('pasiens', 'pasien');
        }
        if (Schema::hasTable('gejalas') && !Schema::hasTable('gejala')) {
            Schema::rename('gejalas', 'gejala');
        }
        if (Schema::hasTable('basis_pengetahuans') && !Schema::hasTable('basis_pengetahuan')) {
            Schema::rename('basis_pengetahuans', 'basis_pengetahuan');
        }
        if (Schema::hasTable('riwayat_konsultasis') && !Schema::hasTable('riwayat_konsultasi')) {
            Schema::rename('riwayat_konsultasis', 'riwayat_konsultasi');
        }
        if (Schema::hasTable('admins') && !Schema::hasTable('admin')) {
            Schema::rename('admins', 'admin');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('pasien')) Schema::rename('pasien', 'pasiens');
        if (Schema::hasTable('gejala')) Schema::rename('gejala', 'gejalas');
        if (Schema::hasTable('basis_pengetahuan')) Schema::rename('basis_pengetahuan', 'basis_pengetahuans');
        if (Schema::hasTable('riwayat_konsultasi')) Schema::rename('riwayat_konsultasi', 'riwayat_konsultasis');
        if (Schema::hasTable('admin')) Schema::rename('admin', 'admins');
    }
};
