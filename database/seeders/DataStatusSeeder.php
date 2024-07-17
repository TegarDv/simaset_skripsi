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
            'nama_status' => 'Aset Normal',
            'color' => 'primary',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('data_status')->insert([
            'nama_status' => 'Aset Diperbaiki',
            'color' => 'primary',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('data_status')->insert([
            'nama_status' => 'Aset Rusak',
            'color' => 'primary',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        for ($i = 0; $i < 7; $i++) {
            DB::table('data_status')->insert([
                'nama_status' => 'Status ' . ($i + 1),
                'color' => 'primary',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
