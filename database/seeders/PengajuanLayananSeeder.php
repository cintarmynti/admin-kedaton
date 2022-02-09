<?php

namespace Database\Seeders;

use App\Models\pengajuan_layanan;
use Illuminate\Database\Seeder;

class PengajuanLayananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        pengajuan_layanan::create([
            'layanan_id' => 1,
            'status' => 'diproses',
            'user_id' => 2,
            'catatan' => 'masihh tes',
            'tanggal' => '2002-10-17',
            'jam' => '12:31:38'
        ]);

        pengajuan_layanan::create([
            'layanan_id' => 1,
            'status' => 'diajukan',
            'user_id' => 2,
            'catatan' => 'masihh tes',
            'tanggal' => '2002-12-16',
            'jam' => '12:31:38'
        ]);

        pengajuan_layanan::create([
            'layanan_id' => 1,
            'status' => 'selesai',
            'user_id' => 2,
            'catatan' => 'masihh tes',
            'tanggal' => '2002-12-16',
            'jam' => '12:31:38'
        ]);


    }
}
