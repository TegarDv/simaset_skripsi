<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DataStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('data_status')->insert([
            'nama_status' => Str::random(10),
            'status' => Str::random(10).'@example.com',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
