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
            'email'    => 'dwi.darma@gmail.com',
            'password'    => bcrypt('password'),
            'user_status' => 'admin'
        ]);

        User::create([
            'id' => 2,
            'name'    => 'fauziyah ramayanti',
            'alamat' => 'jambangan',
            'email'    => 'cinta.ramayanti@gmail.com',
            'nik'    =>  '0993249883',
            'user_status' => 'pengguna',
            'phone' => 12872910,
            'photo_identitas' => null,
            'password'    => null,
            'photo_ktp' => null,
            'status_penghuni' => 'pemilik'

        ]);

        User::create([
            'id' => 3,
            'name'    => 'kirani ramayanti',
            'alamat' => 'buduran',
            'email'    => null,
            'nik'    => '0983402402',
            'phone' => 9083291,
            'user_status' => 'pengguna',
            'photo_identitas' => null,
            'password'    => bcrypt('password456'),
            'photo_ktp' => null,
            'status_penghuni' => 'pemilik'
        ]);


        User::create([
            'id' => 4,
            'name'    => 'laila syafina',
            'email'    => null,
            'alamat' => 'pamulung',
            'nik'    =>  '099329382',
            'user_status' => 'pengguna',
            'phone' => 3338383,
            'photo_identitas' => null,
            'password'    => bcrypt('password789'),
            'photo_ktp' => null,
            'status_penghuni' => 'pemilik'

        ]);

        User::create([
            'id' => 5,
            'name'    => 'bellinda alvania',
            'email'    => null,
            'alamat' => 'linggar jati',
            'nik'    => '0237327',
            'user_status' => 'pengguna',
            'phone' => 12872323,
            'photo_identitas' => null,
            'password'    => bcrypt('password10'),
            'photo_ktp' => null,
            'status_penghuni' => 'penghuni'
        ]);


        User::create([
            'id' => 6,
            'name'    => 'marcella arlistia',
            'email'    => null,
            'alamat' => 'sawahan',
            'nik'    =>  '093284723',
            'user_status' => 'pengguna',
            'phone' => 19327429,
            'photo_identitas' => null,
            'password'    => bcrypt('password'),
            'photo_ktp' => null,
            'status_penghuni' => 'penghuni'

        ]);

        User::create([
            'id' => 7,
            'name'    => 'benedict zefanya',
            'alamat' => 'wonokromo',
            'email'    => null,
            'nik'    => '84772934',
            'user_status' => 'pengguna',
            'phone' => 84327493,
            'photo_identitas' => null,
            'password'    => bcrypt('password'),
            'photo_ktp' => null,
            'status_penghuni' => 'pemilik'
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
