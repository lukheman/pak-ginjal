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
        Schema::create('riwayat_konsultasis', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pasien');
            $table->integer('umur')->nullable();
            $table->json('input_gejala')->comment('Menyimpan id gejala dan input CF user');
            $table->foreignId('hasil_penyakit_cf_id')->nullable()->constrained('penyakit')->nullOnDelete();
            $table->float('nilai_cf')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_konsultasis');
    }
};
