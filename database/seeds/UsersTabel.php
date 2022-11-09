<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTabel extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert(
            [
                'user_code' => 12345678,
                'name' => 'Sarjana Kertas',
                'email' => 'admin11@gmail.com',
                'email_verified_at' => date('Y-m-d H:i:s'),
                'password' => bcrypt('12345678'),
            ]
        );
    }
}
