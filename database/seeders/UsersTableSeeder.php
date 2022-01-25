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
            'name'    => 'cinta ramayanti',
            'email'    => 'cinta.ramayanti@gmail.com',
            'password'    => bcrypt('password'),
            'user_status' => 'admin'
        ]);
    }
}
