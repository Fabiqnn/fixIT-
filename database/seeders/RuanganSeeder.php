<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RuanganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $now = Carbon::now();

        // Data contoh ruangan
        $ruangan = [
            ['kode' => 'R101', 'ket' => 'Ruang Kelas Umum'],
            ['kode' => 'R102', 'ket' => 'Laboratorium Komputer'],
            ['kode' => 'R201', 'ket' => 'Studio Gambar'],
            ['kode' => 'R202', 'ket' => 'Ruang Rapat'],
            ['kode' => 'R301', 'ket' => 'Ruang Dosen'],
            ['kode' => 'R302', 'ket' => 'Ruang Administrasi'],
            ['kode' => 'R401', 'ket' => 'Ruang Multimedia'],
            ['kode' => 'R402', 'ket' => 'Laboratorium Bahasa'],
            ['kode' => 'R501', 'ket' => 'Ruang Seminar'],
            ['kode' => 'R502', 'ket' => 'Perpustakaan'],
        ];

        // Ambil semua lantai dari database
        $lantaiList = DB::table('table_lantai')->get();

        $data = [];
        foreach ($ruangan as $r) {
            // Ambil lantai acak
            $lantai = $lantaiList->random();

            $data[] = [
                'kode_ruangan' => $r['kode'],
                'keterangan'   => $r['ket'],
                'gedung_id'    => $lantai->gedung_id, // dari relasi lantai
                'id_lantai'    => $lantai->id_lantai,
                'created_at'   => $now,
                'updated_at'   => $now,
            ];
        }

        DB::table('table_ruangan')->insert($data);
    }
}
