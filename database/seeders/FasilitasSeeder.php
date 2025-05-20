<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FasilitasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'gedung_id' => 1,
                'nama_fasilitas' => 'Proyektor Aula Sipil',
                'kode_fasilitas' => 'FSL001',
                'tanggal_pengadaan' => '2020-02-15',
                'status' => 'baik',
                'lantai' => 'Lantai 2',
                'ruangan' => 'Ruang A'
            ],
            [
                'gedung_id' => 2,
                'nama_fasilitas' => 'Mesin CNC',
                'kode_fasilitas' => 'FSL002',
                'tanggal_pengadaan' => '2019-07-10',
                'status' => 'rusak',
                'lantai' => 'Lantai 1',
                'ruangan' => 'Ruang B'
            ],
            [
                'gedung_id' => 3,
                'nama_fasilitas' => 'Komputer Lab',
                'kode_fasilitas' => 'FSL003',
                'tanggal_pengadaan' => '2021-01-20',
                'status' => 'baik',
                'lantai' => 'Lantai 3',
                'ruangan' => 'Ruang C'
            ],
            [
                'gedung_id' => 4,
                'nama_fasilitas' => 'Papan Tulis Digital',
                'kode_fasilitas' => 'FSL004',
                'tanggal_pengadaan' => '2022-03-12',
                'status' => 'perlu perbaikan',
                'lantai' => 'Lantai 1',
                'ruangan' => 'Ruang D'
            ],
            [
                'gedung_id' => 5,
                'nama_fasilitas' => 'Printer 3D',
                'kode_fasilitas' => 'FSL005',
                'tanggal_pengadaan' => '2023-06-05',
                'status' => 'baik',
                'lantai' => 'Lantai 2',
                'ruangan' => 'Ruang E'
            ],
            [
                'gedung_id' => 6,
                'nama_fasilitas' => 'Kamera CCTV',
                'kode_fasilitas' => 'FSL006',
                'tanggal_pengadaan' => '2020-08-08',
                'status' => 'baik',
                'lantai' => 'Lantai 1',
                'ruangan' => 'Ruang F'
            ],
            [
                'gedung_id' => 7,
                'nama_fasilitas' => 'AC Ruang Dosen',
                'kode_fasilitas' => 'FSL007',
                'tanggal_pengadaan' => '2021-09-15',
                'status' => 'rusak',
                'lantai' => 'Lantai 2',
                'ruangan' => 'Ruang G'
            ],
            [
                'gedung_id' => 8,
                'nama_fasilitas' => 'Meja Laboratorium',
                'kode_fasilitas' => 'FSL008',
                'tanggal_pengadaan' => '2018-11-10',
                'status' => 'baik',
                'lantai' => 'Lantai 1',
                'ruangan' => 'Ruang H'
            ],
            [
                'gedung_id' => 9,
                'nama_fasilitas' => 'Scanner Dokumen',
                'kode_fasilitas' => 'FSL009',
                'tanggal_pengadaan' => '2022-12-01',
                'status' => 'baik',
                'lantai' => 'Lantai 3',
                'ruangan' => 'Ruang I'
            ],
            [
                'gedung_id' => 10,
                'nama_fasilitas' => 'Whiteboard',
                'kode_fasilitas' => 'FSL010',
                'tanggal_pengadaan' => '2019-04-25',
                'status' => 'perlu perbaikan',
                'lantai' => 'Lantai 1',
                'ruangan' => 'Ruang J'
            ],
            [
                'gedung_id' => 11,
                'nama_fasilitas' => 'Mic Wireless',
                'kode_fasilitas' => 'FSL011',
                'tanggal_pengadaan' => '2020-10-20',
                'status' => 'baik',
                'lantai' => 'Lantai 2',
                'ruangan' => 'Ruang K'
            ],
            [
                'gedung_id' => 12,
                'nama_fasilitas' => 'Speaker Ruang Kelas',
                'kode_fasilitas' => 'FSL012',
                'tanggal_pengadaan' => '2021-05-18',
                'status' => 'baik',
                'lantai' => 'Lantai 1',
                'ruangan' => 'Ruang L'
            ],
            [
                'gedung_id' => 13,
                'nama_fasilitas' => 'TV LED',
                'kode_fasilitas' => 'FSL013',
                'tanggal_pengadaan' => '2022-07-01',
                'status' => 'rusak',
                'lantai' => 'Lantai 3',
                'ruangan' => 'Ruang M'
            ],
            [
                'gedung_id' => 14,
                'nama_fasilitas' => 'UPS Server',
                'kode_fasilitas' => 'FSL014',
                'tanggal_pengadaan' => '2023-01-10',
                'status' => 'baik',
                'lantai' => 'Lantai 1',
                'ruangan' => 'Ruang N'
            ],
            [
                'gedung_id' => 15,
                'nama_fasilitas' => 'Kursi Ergonomis',
                'kode_fasilitas' => 'FSL015',
                'tanggal_pengadaan' => '2020-06-17',
                'status' => 'perlu perbaikan',
                'lantai' => 'Lantai 2',
                'ruangan' => 'Ruang O'
            ],
            [
                'gedung_id' => 16,
                'nama_fasilitas' => 'Laptop Peminjaman',
                'kode_fasilitas' => 'FSL016',
                'tanggal_pengadaan' => '2022-08-24',
                'status' => 'baik',
                'lantai' => 'Lantai 1',
                'ruangan' => 'Ruang P'
            ],
            [
                'gedung_id' => 17,
                'nama_fasilitas' => 'Switch Jaringan',
                'kode_fasilitas' => 'FSL017',
                'tanggal_pengadaan' => '2021-02-28',
                'status' => 'baik',
                'lantai' => 'Lantai 1',
                'ruangan' => 'Ruang Q'
            ],
            [
                'gedung_id' => 18,
                'nama_fasilitas' => 'Kipas Angin',
                'kode_fasilitas' => 'FSL018',
                'tanggal_pengadaan' => '2020-05-19',
                'status' => 'baik',
                'lantai' => 'Lantai 2',
                'ruangan' => 'Ruang R'
            ],
            [
                'gedung_id' => 19,
                'nama_fasilitas' => 'Genset',
                'kode_fasilitas' => 'FSL019',
                'tanggal_pengadaan' => '2019-12-30',
                'status' => 'perlu perbaikan',
                'lantai' => 'Lantai 1',
                'ruangan' => 'Ruang S'
            ],
            [
                'gedung_id' => 1,
                'nama_fasilitas' => 'Modul Praktikum',
                'kode_fasilitas' => 'FSL020',
                'tanggal_pengadaan' => '2023-03-05',
                'status' => 'baik',
                'lantai' => 'Lantai 3',
                'ruangan' => 'Ruang T'
            ],
        ];

        DB::table('table_fasilitas')->insert($data);
    }
}
