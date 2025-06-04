<?php

namespace App\Services;

use App\Models\SPK\AlternatifModel;
use App\Models\SPK\KriteriaModel;
use App\Models\SPK\PenilaianModel;
use Illuminate\Support\Facades\DB;

class MabacService 
{
    public function prosesMabac(array $array) {
        $kriteria = DB::table('table_kriteria')->get();
        $alternatif = DB::table('table_alternatif')->get();
        $penilaian = DB::table('table_penilaian')->get();

        // Persiapan matriks keputusan
        
    }
}