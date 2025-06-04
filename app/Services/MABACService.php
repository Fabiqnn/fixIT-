<?php

namespace App\Services;

use App\Models\SPK\KriteriaModel;

class MabacService
{
    public function prosesMabac(array $array)
    {
        $kriteriaList = KriteriaModel::orderBy('kriteria_id')->get();

        $bobot = [];
        $tipe = [];

        foreach ($kriteriaList as $kriteria) {
            $bobot['K' . $kriteria->kriteria_id] = $kriteria->bobot;
            $tipe['K' . $kriteria->kriteria_id] = $kriteria->tipe_kriteria;
        }

        $X = [];
        foreach ($array as $data) {
            $row = [];
            foreach ($data['nilai'] as $k =>    $v) {
                $row[$k] = $v;
            }
            $X[$data['alternatif_id']] = $row;
        }

        $R = [];
        foreach ($X as $alt_id => $nilai) {
            foreach ($nilai as $k => $v) {
                $kolom = array_column($X, $k);
                $min = min($kolom);
                $max = max($kolom);

                if ($max - $min == 0) {
                    $R[$alt_id][$k] = 0;
                } else {
                    if ($tipe[$k] == 'benefit') {
                        $R[$alt_id][$k] = ($v - $min) / ($max - $min);
                    } else {
                        $R[$alt_id][$k] = ($max - $v) / ($max - $min);
                    }
                }
            }
        }

        $V = [];
        foreach ($R as $alt_id => $nilai) {
            foreach ($nilai as $k => $v) {
                $V[$alt_id][$k] = ($v * $bobot[$k]) + $bobot[$k];
            }
        }

        $G = [];
        $jumlahAlt = count($V);
        foreach ($bobot as $k => $bobotKriteria) {
            $produk = 1;
            foreach ($V as $alt_id => $nilai) {
                $produk *= $nilai[$k];
            }
            $G[$k] = pow($produk, 1 / $jumlahAlt);
        }

        $Q = [];
        foreach ($V as $alt_id => $nilai) {
            $q = 0;
            foreach ($nilai as $k => $v) {
                $q += $v - $G[$k];
            }
            $Q[$alt_id] = $q;
        }

        arsort($Q);
        $rangking = [];
        $i = 1;
        foreach ($Q as $alt_id => $q_val) {
            $rangking[] = [
                'alternatif_id' => $alt_id,
                'nilai_q' => $q_val,
                'ranking' => $i++
            ];
        }

        return [
            'X' => $X,
            'R' => $R,
            'V' => $V,
            'G' => $G,
            'Q' => $Q,
            'rangking' => $rangking
        ];
    }
}
