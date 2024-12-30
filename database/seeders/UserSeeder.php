<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'fullname' => 'User Normal',
            'username' => 'user',
            'email' => 'user@example.com',
            'password' => bcrypt('User123'),
            'role' => 'user',
        ]);
        DB::table('users')->insert([
            'fullname' => 'User Admin',
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('Admin123'),
            'role' => 'admin',
        ]);
    }
}
