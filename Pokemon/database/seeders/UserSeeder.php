<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $user = [
            'username' => 'iWilli',
            'email' => 'willi.nguyen@hotmail.fr',
            'password' => bcrypt('Password'),
            'is_admin' => true,
            'level' => 1,
        ];

        DB::table('users')->insert($user);
    }
}