<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 10; $i++) {
            $formattedCounter = sprintf('%03d', $i + 1); // Formats the counter as three-digit with leading zeros
            $kodeAset = 'DG-KWT9-' . $formattedCounter;

            DB::table('users')->insert([
                'name' => Str::random(10),
                'username' => Str::random(6),
                'email' => Str::random(10).'@example.com',
                'password' => Hash::make('password'),
                'role' => 'Admin',
                'status' => '1',
            ]);
        }
    }
}
