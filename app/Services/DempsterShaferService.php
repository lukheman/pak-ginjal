<?php

namespace App\Services;

use App\Helpers\DempsterShafer;
use App\Models\BasisPengetahuan;

class DempsterShaferService
{
    /**
     * Melakukan perhitungan Dempster-Shafer (DS) dari input user.
     *
     * @param array $inputGejala Array ID gejala dan nilai CF user (Tingkat Keyakinan).
     * @return array Hasil diagnosa beserta persentase.
     */
    public static function diagnosis(array $inputGejala): array
    {
        // Ambil aturan pakar untuk gejala yang dipilih user
        $basis = BasisPengetahuan::with('penyakit')
            ->whereIn('gejala_id', array_keys($inputGejala))
            ->get();

        // Kelompokkan berdasarkan gejala, karena 1 gejala bisa mendukung >1 penyakit (Himpunan)
        $groupedByGejala = $basis->groupBy('gejala_id');

        $dsObjects = [];

        foreach ($groupedByGejala as $gejalaId => $rules) {
            $cfUser = (float) $inputGejala[$gejalaId];
            
            $diseaseIds = [];
            $maxBelief = 0;

            foreach ($rules as $rule) {
                // Gunakan ID penyakit agar mudah direlasikan ke database nanti
                $diseaseIds[] = $rule->penyakit->id; 
                
                $cfPakar = $rule->mb - $rule->md;
                $belief = $cfPakar * $cfUser;
                
                // Ambil nilai belief maksimal dari gejala ini
                if ($belief > $maxBelief) {
                    $maxBelief = $belief;
                }
            }

            // Bentuk subset (misal: "1,2,3")
            sort($diseaseIds);
            $setKey = implode(',', $diseaseIds);

            // Buat instance DS untuk gejala ini
            $ds = new DempsterShafer([
                [$setKey => $maxBelief]
            ]);

            $dsObjects[] = $ds;
        }

        if (empty($dsObjects)) {
            return [
                'id' => null,
                'ds' => 0,
                'percentage' => 0,
                'all_results' => []
            ];
        }

        // Kombinasikan semua evidence DS
        $resultDS = $dsObjects[0];
        for ($i = 1; $i < count($dsObjects); $i++) {
            $resultDS = $resultDS->combinate($dsObjects[$i]);
        }

        // Ekstrak nilai paling maksimum untuk masing-masing id penyakit
        $finalMax = $resultDS->sumBeliefByGejala(); 
        
        $penyakitId = array_key_first($finalMax);
        $dsValue = array_values($finalMax)[0];

        return [
            'id' => $penyakitId,
            'ds' => $dsValue,
            'percentage' => round($dsValue * 100, 2),
            'all_results' => $resultDS->getAllBeliefByGejala()
        ];
    }
}
