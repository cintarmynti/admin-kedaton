<?php

namespace Database\Seeders;

use App\Models\Cluster;
use Illuminate\Database\Seeder;

class ClusterTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Cluster::create([
            'id' => 1,
            'name'    => 'dekat'
        ]);

        Cluster::create([
            'id' => 2,
            'name'    => 'sedang'
        ]);

        Cluster::create([
            'id' => 3,
            'name'    => 'jauh'
        ]);
    }
}
