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
        ];
        DB::table('table_users')->insert($data);
    }
}
