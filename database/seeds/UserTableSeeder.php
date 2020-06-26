<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'admin',
            'username' => 'admin',
            'email' => 'admin@test.com',
            'password' => bcrypt('admin'),
            'is_admin' => 1,
            'api_token' => Str::random(60)
        ]);
    }
}
