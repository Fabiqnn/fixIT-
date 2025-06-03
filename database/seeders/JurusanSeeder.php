<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JurusanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['jurusan_id' => 1, 'jurusan_nama' => 'Teknologi Informasi', 'jurusan_kode' => 'TI'],
            ['jurusan_id' => 2, 'jurusan_nama' => 'Teknik Mesin', 'jurusan_kode' => 'TM'],
            ['jurusan_id' => 3, 'jurusan_nama' => 'Teknik Elektro', 'jurusan_kode' => 'TE'],
            ['jurusan_id' => 4, 'jurusan_nama' => 'Akuntansi', 'jurusan_kode' => 'AKT'],
            ['jurusan_id' => 5, 'jurusan_nama' => 'Teknik Sipil', 'jurusan_kode' => 'TS'],
            ['jurusan_id' => 6, 'jurusan_nama' => 'Teknik Kimia', 'jurusan_kode' => 'TEKIM'],
            ['jurusan_id' => 7, 'jurusan_nama' => 'Administrasi Niaga', 'jurusan_kode' => 'AN']
        ];
        DB::table('table_jurusan')->insert($data);
    }
}
