<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(UsersTableSeeder::class);
        $this->call(tarif_ipklTableSeeder::class);
        $this->call(ListingTableSeeder::class);
        $this->call(ClusterTableSeeder::class);
        $this->call(PropertiTableSeeder::class);
        $this->call(LayananSeeder::class);
    }
}
