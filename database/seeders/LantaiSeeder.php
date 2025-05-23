<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LantaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('table_lantai')->insert([
            [
                'id_lantai'   => 1,
                'nama_lantai' => 'Lantai 1',
                'gedung_id'   => 1,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'id_lantai'   => 2,
                'nama_lantai' => 'Lantai 2',
                'gedung_id'   => 1,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'id_lantai'   => 3,
                'nama_lantai' => 'Lantai 3',
                'gedung_id'   => 1,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'id_lantai'   => 4,
                'nama_lantai' => 'Lantai Dasar',
                'gedung_id'   => 2,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'id_lantai'   => 5,
                'nama_lantai' => 'Lantai 1',
                'gedung_id'   => 2,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'id_lantai'   => 6,
                'nama_lantai' => 'Rooftop',
                'gedung_id'   => 2,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'id_lantai'   => 7,
                'nama_lantai' => 'Basement 1',
                'gedung_id'   => 3,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'id_lantai'   => 8,
                'nama_lantai' => 'Lantai 1',
                'gedung_id'   => 3,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'id_lantai'   => 9,
                'nama_lantai' => 'Lantai 2',
                'gedung_id'   => 3,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'id_lantai'   => 10,
                'nama_lantai' => 'Lantai Atas',
                'gedung_id'   => 3,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
        ]);
    }
}
