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
            'diskon' => null,
            'status' => 'dijual',
            'properti_id' => 1,
            'harga' => 12500000,
            'image' => '/properti_photo/'.'16444074491056.png',
            'setelah_diskon' => 12000000
        ]);

        rev_listing::create([
            'id' => 2,
            'name' => 'Lukbre House',
            'diskon' => null,
            'status' => 'disewa',
            'properti_id' => 2,
            'harga' => 5000000,
            'image' => '/properti_photo/'.'16444075261251.png',
            'setelah_diskon' => 45000000
        ]);

        rev_listing::create([
            'id' => 3,
            'name' => 'Likey House',
            'diskon' => null,
            'status' => 'dijual',
            'properti_id' => 3,
            'harga' => 4000000,
            'image' => '/properti_photo/'.'16444075851990.png',
            'setelah_diskon' => 3000000
        ]);

        rev_listing::create([
            'id' => 4,
            'name' => 'Twice House',
            'diskon' => '15',
            'status' => 'dijual',
            'properti_id' => 4,
            'harga' => 600000,
            'image' => '/properti_photo/'.'1644407727401.png',
            'setelah_diskon' => 5000000
        ]);

        rev_listing::create([
            'id' => 5,
            'name' => 'Fancy House',
            'diskon' => '20',
            'status' => 'dijual',
            'properti_id' => 5,
            'harga' => 236000,
            'image' => '/properti_photo/'.'1644407816205.png',
            'setelah_diskon' => 2120000
        ]);

        rev_listing::create([
            'id' => 6,
            'name' => 'Vanila House',
            'diskon' => '20',
            'status' => 'dijual',
            'properti_id' => 6,
            'harga' => 800000000,
            'image' => '/properti_photo/'.'16445153461612.png',
            'setelah_diskon' => 704590000
        ]);

        rev_listing::create([
            'id' => 7,
            'name' => 'Taro House',
            'diskon' => '5',
            'status' => 'disewa',
            'properti_id' => 7,
            'harga' => 1000000,
            'image' => '/properti_photo/'.'16445154421213.png',
            'setelah_diskon' => 9800000
        ]);


        rev_listing::create([
            'id' => 8,
            'name' => 'Taro House',
            'diskon' => '5',
            'status' => 'disewa',
            'properti_id' => 8,
            'harga' => 1000000,
            'image' => '/properti_photo/'.'1644407816205.png',
            'setelah_diskon' => 9800000
        ]);

        rev_listing::create([
            'id' => 9,
            'name' => 'Sky House',
            'diskon' => null,
            'status' => 'dijual',
            'properti_id' => 9,
            'harga' => 1000000,
            'image' => '/properti_photo/'.'1644515768439.png',
            'setelah_diskon' => null
        ]);

        rev_listing::create([
            'id' => 10,
            'name' => 'blue House',
            'diskon' => null,
            'status' => 'dijual',
            'properti_id' => 10,
            'harga' => 21000000,
            'image' => '/properti_photo/'.'16445158321696.png',
            'setelah_diskon' => null
        ]);


        rev_listing::create([
            'id' => 11,
            'name' => 'charlie House',
            'diskon' => null,
            'status' => 'disewa',
            'properti_id' => 11,
            'harga' => 21000000,
            'image' => '/properti_photo/'.'1644407816205.png',
            'setelah_diskon' => null
        ]);
    }
}
