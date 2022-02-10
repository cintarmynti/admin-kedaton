<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'id' => 1,
            'name'    => 'cinta ramayanti',
            'email'    => 'cinta.ramayanti@gmail.com',
            'password'    => bcrypt('password'),
            'user_status' => 'admin'
        ]);

        User::create([
            'id' => 2,
            'name'    => 'fauziyah ramayanti',
            'alamat' => 'jambangan',
            'email'    => 'fafa.ramayanti@gmail.com',
            'nik'    =>  '0993249883',
            'user_status' => 'pengguna',
            'phone' => 12872910,
            'photo_identitas' => null,
            'password'    => bcrypt('password123'),

        ]);

        User::create([
            'id' => 3,
            'name'    => 'kirani ramayanti',
            'alamat' => 'buduran',
            'email'    => 'kirani.ramayanti@gmail.com',
            'nik'    => '0983402402',
            'phone' => 9083291,
            'user_status' => 'pengguna',
            'photo_identitas' => null,
            'password'    => bcrypt('password456'),
        ]);


        User::create([
            'id' => 4,
            'name'    => 'laila syafina',
            'email'    => 'laila.syafina@gmail.com',
            'alamat' => 'pamulung',
            'nik'    =>  '099329382',
            'user_status' => 'pengguna',
            'phone' => 3338383,
            'photo_identitas' => null,
            'password'    => bcrypt('password789'),

        ]);

        User::create([
            'id' => 5,
            'name'    => 'bellinda alvania',
            'email'    => 'bellinda.ramayanti@gmail.com',
            'alamat' => 'linggar jati',
            'nik'    => '0237327',
            'user_status' => 'pengguna',
            'phone' => 12872323,
            'photo_identitas' => null,
            'password'    => bcrypt('password10'),
        ]);


        User::create([
            'id' => 6,
            'name'    => 'marcella arlistia',
            'email'    => 'marcella.ramayanti@gmail.com',
            'alamat' => 'sawahan',

            'nik'    =>  '093284723',
            'user_status' => 'pengguna',
            'phone' => 19327429,
            'photo_identitas' => null,
            'password'    => bcrypt('password'),

        ]);

        User::create([
            'id' => 7,
            'name'    => 'benedict zefanya',
            'alamat' => 'wonokromo',

            'email'    => 'benedicta.ramayanti@gmail.com',
            'nik'    => '84772934',
            'user_status' => 'pengguna',
            'phone' => 84327493,
            'photo_identitas' => null,
            'password'    => bcrypt('password'),
        ]);

        User::create([
            'id' => 8,
            'name'    => 'admin kedaton',
            'email'    => 'admin@kedaton.com',
            'password'    => bcrypt('kedatonjaya'),
            'user_status' => 'admin'
        ]);
    }
}
