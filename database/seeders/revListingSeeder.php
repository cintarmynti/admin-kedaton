<?php

namespace Database\Seeders;

use App\Models\rev_listing;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class revListingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        rev_listing::create([
            'id' => 1,
            'name' => 'Lukbre House',
            'diskon' => '50',
            'status' => 'dijual',
            'properti_id' => 1,
            'harga' => 12500000,
            'image' => '16444074491056.png',
            'setelah_diskon' => 12000000
        ]);

        rev_listing::create([
            'id' => 2,
            'name' => 'Lukbre House',
            'diskon' => '5',
            'status' => 'disewa',
            'properti_id' => 2,
            'harga' => 5000000,
            'image' => '16444075261251.png',
            'setelah_diskon' => 45000000
        ]);

        rev_listing::create([
            'id' => 3,
            'name' => 'Likey House',
            'diskon' => '6',
            'status' => 'dijual',
            'properti_id' => 3,
            'harga' => 4000000,
            'image' => '16444075851990.png',
            'setelah_diskon' => 3000000
        ]);

        rev_listing::create([
            'id' => 4,
            'name' => 'Twice House',
            'diskon' => '15',
            'status' => 'dijual',
            'properti_id' => 4,
            'harga' => 600000,
            'image' => '1644407727401.png',
            'setelah_diskon' => 5000000
        ]);

        rev_listing::create([
            'id' => 5,
            'name' => 'Fancy House',
            'diskon' => '20',
            'status' => 'dijual',
            'properti_id' => 5,
            'harga' => 236000,
            'image' => '1644407816205.png',
            'setelah_diskon' => 2120000
        ]);
    }
}
