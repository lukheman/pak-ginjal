<?php

namespace App\Helpers;

class DempsterShafer
{
    public array $matrix; // [['P1,P2,P3' => 0.4]]

    public function __construct(array $matrix)
    {
        $this->matrix = $matrix;
    }

    /**
     * Menghitung nilai plausibility dan mengembalikan set kesemestaan.
     */
    public function plausibility(): array
    {
        $keys = [];
        $plausibility = 1.0;

        // Jangan memutasi state matrix asli secara permanen di fungsi getter, 
        // filter secara lokal saja agar tidak terjadi efek samping (side-effect).
        $filteredMatrix = array_filter($this->matrix, function ($item) {
            return !empty(key($item));
        });

        foreach ($filteredMatrix as $row) {
            $key = key($row);
            $value = current($row);
            
            if ($key !== '') {
                $keys[] = $key;
                $plausibility -= $value;
            }
        }

        $keys = $this->unionArrays($keys);

        return [$keys => round($plausibility, 6)];
    }

    /**
     * Mendapatkan total belief dari seluruh himpunan.
     */
    public function totalBelief(): float
    {
        $belief = 0.0;

        foreach ($this->matrix as $row) {
            $belief += current($row);
        }

        return $belief;
    }

    /**
     * Membuang set yang bernilai kosong (konflik).
     */
    public function filterConflict(): void
    {
        $this->matrix = array_filter($this->matrix, function ($item) {
            return !empty(key($item));
        });
        
        // Re-index array setelah difilter
        $this->matrix = array_values($this->matrix);
    }

    /**
     * Mengurutkan elemen di dalam string himpunan, cth: 'P3,P1' -> 'P1,P3'
     */
    private function sortingKey(string $key): string
    {
        $keys = explode(',', $key);
        sort($keys);
        
        return implode(',', $keys);
    }

    /**
     * Kombinasi dengan matrix Dempster-Shafer lain (Dempster's Rule of Combination).
     */
    public function combinate(DempsterShafer $other): DempsterShafer
    {
        $result = [];
        
        // Ambil elemen pertama dari matriks 'other' (asumsi other selalu merepresentasikan single evidence)
        $otherRow = $other->matrix[0];
        $otherKey = $this->sortingKey(key($otherRow));
        $otherBelief = current($otherRow);
        
        // Cache plausibility untuk menghindari komputasi berulang yang sangat mahal di dalam loop
        $thisPlausibilityArray = $this->plausibility();
        $otherPlausibilityArray = $other->plausibility();

        // 1. Matriks M1 x Belief M2
        foreach ($this->matrix as $row) {
            $set1 = $this->sortingKey(key($row));
            $new_belief = current($row) * $otherBelief;

            $intersectKey = $this->intersect($set1, $otherKey);
            $result[] = [$intersectKey => $new_belief];
        }

        // 2. Plausibility M1 x Belief M2
        $thisPlausibilityValue = current($thisPlausibilityArray);
        $new_belief_plaus1 = $thisPlausibilityValue * $otherBelief;
        
        $result[] = [$otherKey => $new_belief_plaus1];

        // 3. Matriks M1 x Plausibility M2
        $otherPlausibilityValue = current($otherPlausibilityArray);
        foreach ($this->matrix as $row) {
            $set1 = key($row);
            $new_belief_plaus2 = current($row) * $otherPlausibilityValue;

            $resultKey = $this->sortingKey($set1);
            $result[] = [$resultKey => $new_belief_plaus2];
        }

        return new DempsterShafer($this->normalisasi($result));
    }

    /**
     * Menjumlahkan nilai belief untuk subset/himpunan yang sama.
     */
    private function normalisasi(array $matrix): array
    {
        $summary = [];

        foreach ($matrix as $item) {
            $key = key($item);
            $value = current($item);
            
            if (!isset($summary[$key])) {
                $summary[$key] = 0;
            }
            $summary[$key] += $value;
        }

        // Format ulang ke bentuk array of array (matrix)
        $normalized = [];
        foreach ($summary as $key => $value) {
            $normalized[] = [$key => $value];
        }

        return $normalized;
    }

    /**
     * Menggabungkan beberapa himpunan string menjadi satu string himpunan gabungan.
     */
    private function unionArrays(array $array): string
    {
        $all = [];
        foreach ($array as $item) {
            $all = array_merge($all, explode(',', $item));
        }

        $unique = array_unique($all);
        return $this->sortingKey(implode(',', $unique));
    }

    /**
     * Mencari irisan dari dua himpunan string.
     */
    private function intersect(string $a, string $b): string
    {
        if ($a === '' || $b === '') return '';
        
        $arrA = explode(',', $a);
        $arrB = explode(',', $b);
        $intersect = array_intersect($arrA, $arrB);

        return $this->sortingKey(implode(',', $intersect));
    }

    /**
     * Mendapatkan entri matrix dengan belief tertinggi.
     */
    public function getMaxValue(): array
    {
        $maxValue = 0.0;
        $maxKey = '';

        foreach ($this->matrix as $row) {
            $key = key($row);
            $value = current($row);
            
            if ($value > $maxValue) {
                $maxValue = $value;
                $maxKey = $key;
            }
        }

        return [$maxKey => $maxValue];
    }

    /**
     * Menghitung total nilai belief per kode penyakit dengan memecah subset yang digabung.
     */
    private function calculateSumBeliefs(): array
    {
        $result = [];

        foreach ($this->matrix as $entry) {
            $diseases = key($entry);
            $belief = current($entry);
            
            if (empty($diseases)) continue;
            
            $diseaseCodes = explode(',', $diseases);

            foreach ($diseaseCodes as $code) {
                $code = trim($code);
                if (!isset($result[$code])) {
                    $result[$code] = 0.0;
                }
                $result[$code] += $belief;
            }
        }

        foreach ($result as $code => $value) {
            $result[$code] = round($value, 4);
        }

        return $result;
    }

    /**
     * Mendapatkan penyakit tunggal dengan total belief tertinggi.
     */
    public function sumBeliefByGejala(): array
    {
        $summedBeliefs = $this->calculateSumBeliefs();
        return $this->maxBeliefGejala($summedBeliefs);
    }

    /**
     * Mengembalikan semua kode penyakit beserta total nilai belief-nya, diurutkan menurun.
     */
    public function getAllBeliefByGejala(): array
    {
        $summedBeliefs = $this->calculateSumBeliefs();
        arsort($summedBeliefs);
        
        return $summedBeliefs;
    }

    /**
     * Mengambil elemen dengan nilai terbesar dari array.
     */
    private function maxBeliefGejala(array $array): array
    {
        if (empty($array)) return [];
        
        $maxValue = max($array);
        $maxKey = array_search($maxValue, $array);

        return [$maxKey => $maxValue];
    }
}
