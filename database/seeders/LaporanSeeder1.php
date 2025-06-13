<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LaporanSeeder1 extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dataLaporan = [
            ['kode_laporan' => 'L001', 'no_induk' => '1234567891', 'fasilitas_id' => 5, 'tanggal_laporan' => '2025-05-01', 'deskripsi_kerusakan' => 'Keran bocor terus-menerus',  'status_acc' => 'pending', 'foto_kerusakan' => 'kerusakan1.jpg'],
            ['kode_laporan' => 'L002', 'no_induk' => '1234567891', 'fasilitas_id' => 11, 'tanggal_laporan' => '2025-05-03', 'deskripsi_kerusakan' => 'Stop kontak tidak berfungsi',  'status_acc' => 'disetujui', 'foto_kerusakan' => 'kerusakan2.jpg'],
            ['kode_laporan' => 'L003', 'no_induk' => '1234567892', 'fasilitas_id' => 7, 'tanggal_laporan' => '2025-05-02', 'deskripsi_kerusakan' => 'Pintu tidak bisa dikunci', 'status_acc' => 'disetujui', 'foto_kerusakan' => 'kerusakan3.jpg'],
            ['kode_laporan' => 'L004', 'no_induk' => '1234567892', 'fasilitas_id' => 14, 'tanggal_laporan' => '2025-05-05', 'deskripsi_kerusakan' => 'AC tidak dingin', 'status_acc' => 'pending', 'foto_kerusakan' => 'kerusakan4.jpg'],
            ['kode_laporan' => 'L005', 'no_induk' => '1234567895', 'fasilitas_id' => 9, 'tanggal_laporan' => '2025-05-06', 'deskripsi_kerusakan' => 'Meja goyah', 'status_acc' => 'ditolak', 'foto_kerusakan' => 'kerusakan10.jpg'],
            ['kode_laporan' => 'L006', 'no_induk' => '1234567896', 'fasilitas_id' => 6, 'tanggal_laporan' => '2025-05-05', 'deskripsi_kerusakan' => 'Toilet mampet', 'status_acc' => 'disetujui', 'foto_kerusakan' => 'kerusakan11.jpg'],
            ['kode_laporan' => 'L007', 'no_induk' => '1234567896', 'fasilitas_id' => 14, 'tanggal_laporan' => '2025-05-06', 'deskripsi_kerusakan' => 'Atap retak', 'status_acc' => 'disetujui', 'foto_kerusakan' => 'kerusakan12.jpg'],
            ['kode_laporan' => 'L008', 'no_induk' => '1234567897', 'fasilitas_id' => 2, 'tanggal_laporan' => '2025-05-01', 'deskripsi_kerusakan' => 'Kipas angin mati', 'status_acc' => 'pending', 'foto_kerusakan' => 'kerusakan13.jpg'],
            ['kode_laporan' => 'L009', 'no_induk' => '1234567898', 'fasilitas_id' => 2, 'tanggal_laporan' => '2025-05-07', 'deskripsi_kerusakan' => 'Tembok lembab', 'status_acc' => 'disetujui', 'foto_kerusakan' => 'kerusakan14.jpg'],
            ['kode_laporan' => 'L010', 'no_induk' => '1234567898', 'fasilitas_id' => 4, 'tanggal_laporan' => '2025-05-07', 'deskripsi_kerusakan' => 'Handle pintu lepas', 'status_acc' => 'pending', 'foto_kerusakan' => 'kerusakan15.jpg'],
            ['kode_laporan' => 'L011', 'no_induk' => '1234567899', 'fasilitas_id' => 8, 'tanggal_laporan' => '2025-05-02', 'deskripsi_kerusakan' => 'Lemari rusak', 'status_acc' => 'disetujui', 'foto_kerusakan' => 'kerusakan16.jpg'],
            ['kode_laporan' => 'L012', 'no_induk' => '1234567899', 'fasilitas_id' => 19, 'tanggal_laporan' => '2025-05-09', 'deskripsi_kerusakan' => 'Speaker tidak mengeluarkan suara', 'status_acc' => 'disetujui', 'foto_kerusakan' => 'kerusakan17.jpg'],
            ['kode_laporan' => 'L013', 'no_induk' => '2341720170', 'fasilitas_id' => 19, 'tanggal_laporan' => '2025-05-08', 'deskripsi_kerusakan' => 'Tirai robek', 'status_acc' => 'pending', 'foto_kerusakan' => 'kerusakan18.jpg'],
            ['kode_laporan' => 'L014', 'no_induk' => '2341720170', 'fasilitas_id' => 20, 'tanggal_laporan' => '2025-05-09', 'deskripsi_kerusakan' => 'Rak buku patah', 'status_acc' => 'disetujui', 'foto_kerusakan' => 'kerusakan19.jpg'],
            ['kode_laporan' => 'L015', 'no_induk' => '2341720170', 'fasilitas_id' => 1, 'tanggal_laporan' => '2025-05-10', 'deskripsi_kerusakan' => 'Tangga berderit parah', 'status_acc' => 'disetujui', 'foto_kerusakan' => 'kerusakan20.jpg'],
        ];
        DB::table('table_laporan')->insert($dataLaporan);
    }
}
