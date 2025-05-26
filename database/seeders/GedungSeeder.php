<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GedungSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['gedung_id' => 1, 'gedung_nama' => 'T.Sipil'],
            ['gedung_id' => 2, 'gedung_nama' => 'T.Mesin'],
            ['gedung_id' => 3, 'gedung_nama' => 'AS'],
            ['gedung_id' => 4, 'gedung_nama' => 'AI'],
            ['gedung_id' => 5, 'gedung_nama' => 'AM'],
            ['gedung_id' => 6, 'gedung_nama' => 'AL'],
            ['gedung_id' => 7, 'gedung_nama' => 'AK'],
            ['gedung_id' => 8, 'gedung_nama' => 'AJ'],
            ['gedung_id' => 9, 'gedung_nama' => 'AD'],
            ['gedung_id' => 10, 'gedung_nama' => 'AC'],
            ['gedung_id' => 11, 'gedung_nama' => 'AB'],
            ['gedung_id' => 12, 'gedung_nama' => 'AE'],
            ['gedung_id' => 13, 'gedung_nama' => 'AA'],
            ['gedung_id' => 14, 'gedung_nama' => 'AF'],
            ['gedung_id' => 15, 'gedung_nama' => 'AG'],
            ['gedung_id' => 16, 'gedung_nama' => 'AH'],
            ['gedung_id' => 17, 'gedung_nama' => 'AO'],
            ['gedung_id' => 18, 'gedung_nama' => 'AQ'],
            ['gedung_id' => 19, 'gedung_nama' => 'AP'],
        ];
        DB::table('table_gedung')->insert($data);
    }
}