<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PeriodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['periode_id' => 1, 'nama_periode' => 'Mei 2025', 'tanggal_mulai' => '2025-05-01', 'tanggal_selesai' => '2025-05-31'],
            ['periode_id' => 2, 'nama_periode' => 'Juni 2025', 'tanggal_mulai' => '2025-06-01', 'tanggal_selesai' => '2025-06-30'],
            ['periode_id' => 3, 'nama_periode' => 'Juli 2025', 'tanggal_mulai' => '2025-07-01', 'tanggal_selesai' => '2025-07-31'],
            ['periode_id' => 4, 'nama_periode' => 'Agustus 2025', 'tanggal_mulai' => '2025-08-01', 'tanggal_selesai' => '2025-08-31'],
            ['periode_id' => 5, 'nama_periode' => 'September 2025', 'tanggal_mulai' => '2025-09-01', 'tanggal_selesai' => '2025-09-30'],
        ];

        DB::table('table_periode')->insert($data);
    }
}
