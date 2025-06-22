<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['no_induk' => '234172012398', 'level_id' => 2, 'password' => Hash::make('12345'), 'nama_lengkap' => 'Adani Salsabila'],
            ['no_induk' => '234172017098', 'level_id' => 2, 'password' => Hash::make('12345'), 'nama_lengkap' => 'Fabian Hasbillah Ogya-Cetta'],
            ['no_induk' => '234172012098', 'level_id' => 2, 'password' => Hash::make('12345'), 'nama_lengkap' => 'Roy Wijaya'],
            ['no_induk' => '234172019198', 'level_id' => 2, 'password' => Hash::make('12345'), 'nama_lengkap' => 'Soultan Agnar Muhammad Bisyara'],
            ['no_induk' => '234172015998', 'level_id' => 2, 'password' => Hash::make('12345'), 'nama_lengkap' => 'Textona Ardha'],
            ['no_induk' => '2341720123', 'level_id' => 1, 'password' => Hash::make('12345'), 'nama_lengkap' => 'Adani Salsabila'],
            ['no_induk' => '2341720170', 'level_id' => 1, 'password' => Hash::make('12345'), 'nama_lengkap' => 'Fabian Hasbillah Ogya-Cetta'],
            ['no_induk' => '2341720120', 'level_id' => 1, 'password' => Hash::make('12345'), 'nama_lengkap' => 'Roy Wijaya'],
            ['no_induk' => '2341720191', 'level_id' => 1, 'password' => Hash::make('12345'), 'nama_lengkap' => 'Soultan Agnar Muhammad Bisyara'],
            ['no_induk' => '2341720159', 'level_id' => 1, 'password' => Hash::make('12345'), 'nama_lengkap' => 'Textona Ardha'],
            ['no_induk' => '2341720123987', 'level_id' => 3, 'password' => Hash::make('12345'), 'nama_lengkap' => 'Adani Salsabila'],
            ['no_induk' => '2341720170987', 'level_id' => 3, 'password' => Hash::make('12345'), 'nama_lengkap' => 'Fabian Hasbillah Ogya-Cetta'],
            ['no_induk' => '2341720120987', 'level_id' => 3, 'password' => Hash::make('12345'), 'nama_lengkap' => 'Roy Wijaya'],
            ['no_induk' => '2341720191987', 'level_id' => 3, 'password' => Hash::make('12345'), 'nama_lengkap' => 'Soultan Agnar Muhammad Bisyara'],
            ['no_induk' => '2341720159987', 'level_id' => 3, 'password' => Hash::make('12345'), 'nama_lengkap' => 'Textona Ardha'],
            ['no_induk' => '1234567890', 'level_id' => 1, 'password' => Hash::make('12345'), 'nama_lengkap' => 'Raka Dwi Prasetya'],
            ['no_induk' => '1234567891', 'level_id' => 1, 'password' => Hash::make('12345'), 'nama_lengkap' => 'Nadira Putri Ayu'],
            ['no_induk' => '1234567892', 'level_id' => 1, 'password' => Hash::make('12345'), 'nama_lengkap' => 'Faris Al Hakim'],
            ['no_induk' => '1234567893', 'level_id' => 1, 'password' => Hash::make('12345'), 'nama_lengkap' => 'Tiara Anindya Larasati'],
            ['no_induk' => '1234567894', 'level_id' => 1, 'password' => Hash::make('12345'), 'nama_lengkap' => 'Bayu Muhammad Rizki'],
            ['no_induk' => '1234567895', 'level_id' => 1, 'password' => Hash::make('12345'), 'nama_lengkap' => 'Salsabila Nur Aini'],
            ['no_induk' => '1234567896', 'level_id' => 1, 'password' => Hash::make('12345'), 'nama_lengkap' => 'Rizka Amaliah'],
            ['no_induk' => '1234567897', 'level_id' => 1, 'password' => Hash::make('12345'), 'nama_lengkap' => 'Ardiansyah Mahesa'],
            ['no_induk' => '1234567898', 'level_id' => 1, 'password' => Hash::make('12345'), 'nama_lengkap' => 'Dewi Kartika Sari'],
            ['no_induk' => '1234567899', 'level_id' => 1, 'password' => Hash::make('12345'), 'nama_lengkap' => 'Fahmi Ghifari Ramadhan'],
        ];
        DB::table('table_users')->insert($data);
    }
}
