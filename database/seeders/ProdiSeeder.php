<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProdiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['prodi_id' => 1, 'prodi_nama' => 'D4 Teknik Informatika', 'jurusan_id' => 1 , 'prodi_kode' => 'TI'],
            ['prodi_id' => 2, 'prodi_nama' => 'D4 Sistem Informasi Bisnis', 'jurusan_id' => 1 , 'prodi_kode' => 'SIB'],
            ['prodi_id' => 3, 'prodi_nama' => 'D3 Teknik Mesin', 'jurusan_id' => 2 , 'prodi_kode' => 'TM'],
            ['prodi_id' => 4, 'prodi_nama' => 'D4 Teknik Otomotif Elektronik', 'jurusan_id' => 2 , 'prodi_kode' => 'TOE'],
            ['prodi_id' => 5, 'prodi_nama' => 'D4 Teknik Mesin Produksi dan Perawatan', 'jurusan_id' => 2 , 'prodi_kode' => 'TMPP'],
            ['prodi_id' => 6, 'prodi_nama' => 'S2 Teknologi Rekayasa Teknik Terapan', 'jurusan_id' => 2 , 'prodi_kode' => 'TRTT'],
            ['prodi_id' => 7, 'prodi_nama' => 'D3 Teknik Elektronika', 'jurusan_id' => 3 , 'prodi_kode' => 'TE'],
            ['prodi_id' => 8, 'prodi_nama' => 'D3 Teknik Telekomunikasi', 'jurusan_id' => 3 , 'prodi_kode' => 'TT'],
            ['prodi_id' => 9, 'prodi_nama' => 'D3 Teknik Listrik', 'jurusan_id' => 3 , 'prodi_kode' => 'TL'],
            ['prodi_id' => 10, 'prodi_nama' => 'D4 Jaringan Telekomunikasi Digital', 'jurusan_id' => 3 , 'prodi_kode' => 'JTD'],
            ['prodi_id' => 11, 'prodi_nama' => 'D4 Sistem Kelistrikan', 'jurusan_id' => 3 , 'prodi_kode' => 'SK'],
            ['prodi_id' => 12, 'prodi_nama' => 'D4 Teknik Elektronika', 'jurusan_id' => 3 , 'prodi_kode' => 'TE'],
            ['prodi_id' => 13, 'prodi_nama' => 'S2 Magister Terapan Teknik Elektro', 'jurusan_id' => 3 , 'prodi_kode' => 'MTT'],
            ['prodi_id' => 14, 'prodi_nama' => 'D3 Akuntansi', 'jurusan_id' => 4 , 'prodi_kode' => 'Akuntansi'],
            ['prodi_id' => 15, 'prodi_nama' => 'D3 Akuntansi (PSDKU Kediri)', 'jurusan_id' => 4 , 'prodi_kode' => 'AkuntansiK'],
            ['prodi_id' => 16, 'prodi_nama' => 'D4 Akuntansi Manajemen', 'jurusan_id' => 4 , 'prodi_kode' => 'AM'],
            ['prodi_id' => 17, 'prodi_nama' => 'D4 Keuangan', 'jurusan_id' => 4 , 'prodi_kode' => 'Keuangan'],
            ['prodi_id' => 18, 'prodi_nama' => 'S2 Sistem Informasi Akuntansi', 'jurusan_id' => 4 , 'prodi_kode' => 'SIA'],
            ['prodi_id' => 19, 'prodi_nama' => 'D3 Teknik Sipil', 'jurusan_id' => 5 , 'prodi_kode' => 'TS'],
            ['prodi_id' => 20, 'prodi_nama' => 'D3 Teknik Pertambangan', 'jurusan_id' => 5 , 'prodi_kode' => 'TP'],
            ['prodi_id' => 21, 'prodi_nama' => 'D3 Teknologi Rekayasa Konstruksi Jalan, Jembatan dan Bangunan Air', 'jurusan_id' => 5 , 'prodi_kode' => 'TR'],
            ['prodi_id' => 22, 'prodi_nama' => 'D4 Manajemen Rekayasa Konstruksi', 'jurusan_id' => 5 , 'prodi_kode' => 'MRK'],
            ['prodi_id' => 23, 'prodi_nama' => 'D4 Teknologi Rekayasa Konstruksi Jalan dan Jembatan', 'jurusan_id' => 5 , 'prodi_kode' => 'TRD4'],
            ['prodi_id' => 24, 'prodi_nama' => 'D3 Teknik Kimia', 'jurusan_id' => 6 , 'prodi_kode' => 'TekKim3'],
            ['prodi_id' => 25, 'prodi_nama' => 'D4 Teknik Kimia', 'jurusan_id' => 6 , 'prodi_kode' => 'TekKim4'],
            ['prodi_id' => 26, 'prodi_nama' => 'D3 Administrasi Bisnis', 'jurusan_id' => 7 , 'prodi_kode' => 'AB3'],
            ['prodi_id' => 27, 'prodi_nama' => 'D3 Bahasa Inggris', 'jurusan_id' => 7 , 'prodi_kode' => 'BING3'],
            ['prodi_id' => 28, 'prodi_nama' => 'D4 Manajemen Pemasaran', 'jurusan_id' => 7 , 'prodi_kode' => 'MP'],
            ['prodi_id' => 29, 'prodi_nama' => 'D4 Bahasa Inggris', 'jurusan_id' => 7 , 'prodi_kode' => 'BING4'],
        ];
        DB::table('table_prodi')->insert($data);
    }
}
