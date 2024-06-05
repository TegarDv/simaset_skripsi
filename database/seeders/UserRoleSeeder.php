<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users_role')->insert([
            'id' => 1,
            'name' => 'Super Admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('users_role')->insert([
            'id' => 2,
            'name' => 'Admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('users_role')->insert([
            'id' => 3,
            'name' => 'Dosen / Mahasiswa',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
