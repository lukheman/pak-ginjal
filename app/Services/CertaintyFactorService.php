<?php

namespace App\Services;

use App\Helpers\CertaintyFactor;
use App\Models\Penyakit;

class CertaintyFactorService
{
    /**
     * Melakukan diagnosa berdasarkan Certainty Factor (CF) dari input user.
     *
     * @param array $ceraintyFactorUser Array berisi pasangan id gejala dan nilai CF dari user.
     * @return array Hasil diagnosa beserta persentase.
     */
    public static function diagnosis(array $ceraintyFactorUser): array
    {
        $dataAll = Penyakit::with('gejala')->get();
        $cfResults = [];

        foreach ($dataAll as $item) {
            foreach ($item->gejala as $gejala) {
                if (isset($ceraintyFactorUser[$gejala->id]) && floatval($ceraintyFactorUser[$gejala->id]) > 0) {
                    $mb = $gejala->pivot->mb;
                    $md = $gejala->pivot->md;

                    $cfPakar = CertaintyFactor::cfPakar($mb, $md);
                    $cf = CertaintyFactor::cfPakarMultiplyCfUser($cfPakar, (float) $ceraintyFactorUser[$gejala->id]);

                    if (isset($cfResults[$item->id])) {
                        $cfResults[$item->id] = CertaintyFactor::combine($cfResults[$item->id], $cf);
                    } else {
                        $cfResults[$item->id] = $cf;
                    }
                }
            }
        }

        if (empty($cfResults)) {
            return [
                'id' => null,
                'cf' => 0,
                'percentage' => 0
            ];
        }

        return self::getMaxCf($cfResults);
    }

    /**
     * Dapatkan item dengan nilai Certainty Factor tertinggi
     *
     * @param array $cfResults
     * @return array
     */
    public static function getMaxCf(array $cfResults): array
    {
        $maxCf = max($cfResults);
        $itemId = array_search($maxCf, $cfResults);
        return [
            'id' => $itemId,
            'cf' => $maxCf,
            'percentage' => round($maxCf * 100, 2),
            'all_results' => $cfResults // Also return all results for detailed views
        ];
    }
}
