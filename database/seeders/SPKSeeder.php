<?php

namespace Database\Seeders;

use App\Models\LaporanModel;
use App\Models\SPK\AlternatifModel;
use App\Models\SPK\KriteriaModel;
use App\Models\SPK\PenilaianModel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use function Laravel\Prompts\table;

class SPKSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kriteria = [
            ['kriteria_id' => 1, 'nama_kriteria' => 'Jumlah Pelaporan', 'tipe_kriteria' => 'benefit', 'bobot' => 20],
            ['kriteria_id' => 2, 'nama_kriteria' => 'Tingkat Kerusakan', 'tipe_kriteria' => 'benefit', 'bobot' => 25],
            ['kriteria_id' => 3, 'nama_kriteria' => 'Dampak Terhadap Kegiatan', 'tipe_kriteria' => 'benefit', 'bobot' => 30],
            ['kriteria_id' => 4, 'nama_kriteria' => 'Estimasi Biaya Perbaikan', 'tipe_kriteria' => 'cost', 'bobot' => 10],
            ['kriteria_id' => 5, 'nama_kriteria' => 'Durasi Kerusakan Belum Diperbaiki', 'tipe_kriteria' => 'benefit', 'bobot' => 15],
        ];

        DB::table('table_kriteria')->insert($kriteria);
    }
}
