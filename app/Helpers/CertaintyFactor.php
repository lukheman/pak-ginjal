<?php

namespace App\Helpers;

/**
 * Kelas utilitas untuk kalkulasi matematika metode Certainty Factor (CF).
 * Kelas ini terdiri dari metode statis murni sehingga dideklarasikan final 
 * dan tidak bisa di-instansiasi.
 */
final class CertaintyFactor
{
    /**
     * Private constructor untuk mencegah instansiasi (new CertaintyFactor)
     * karena kelas ini murni sebuah utility/helper.
     */
    private function __construct()
    {
        // 
    }

    /**
     * Hitung nilai Certainty Factor Pakar (CF Pakar).
     * Rumus dasar: Measure of Belief (MB) - Measure of Disbelief (MD).
     *
     * @param float $mb Tingkat keyakinan pakar terhadap suatu gejala (0.0 sampai 1.0)
     * @param float $md Tingkat ketidakyakinan pakar terhadap suatu gejala (0.0 sampai 1.0)
     * @return float Hasil perhitungan CF Pakar
     */
    public static function cfPakar(float $mb, float $md): float
    {
        return $mb - $md;
    }

    /**
     * Hitung nilai bobot CF akhir dari satu gejala.
     * Rumus: CF Pakar x CF User.
     *
     * @param float $cfPakar Hasil pengurangan (MB - MD) dari pakar
     * @param float $cfUser Tingkat keyakinan yang dipilih/diinput oleh user
     * @return float Hasil perkalian kepastian CF Gejala
     */
    public static function cfPakarMultiplyCfUser(float $cfPakar, float $cfUser): float
    {
        return $cfPakar * $cfUser;
    }

    /**
     * Kombinasikan dua nilai Certainty Factor menjadi satu CF Gabungan (Combine).
     * Digunakan ketika ada lebih dari satu gejala yang merujuk pada penyakit yang sama.
     * 
     * Rumus: CF_Lama + CF_Baru * (1 - abs(CF_Lama))
     *
     * @param float $cfOld Nilai kepastian kumulatif sebelumnya (CF Lama)
     * @param float $cfNew Nilai kepastian gejala berikutnya (CF Baru)
     * @return float Hasil kombinasi CF terbaru
     */
    public static function combine(float $cfOld, float $cfNew): float
    {
        return $cfOld + $cfNew * (1.0 - abs($cfOld));
    }
}
