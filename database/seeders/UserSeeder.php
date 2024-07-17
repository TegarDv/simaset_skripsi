<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Super Admin',
            'username' => 'superadmin',
            'nim' => '0',
            'nip' => '0',
            'email' => 'superadmin@example.com',
            'password' => Hash::make('password'),
            'role' => '1',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('users')->insert([
            'name' => 'Admin',
            'username' => 'admin',
            'nim' => '0',
            'nip' => '0',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => '2',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('users')->insert([
            'name' => 'User',
            'username' => 'user',
            'nim' => '0',
            'nip' => '0',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
            'role' => '3',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        for ($i = 0; $i < 9; $i++) {
            DB::table('users')->insert([
                'name' => Str::random(10),
                'username' => Str::random(6),
                'nim' => '0',
                'nip' => '0',
                'email' => Str::random(10).'@example.com',
                'password' => Hash::make('password'),
                'role' => '3',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
