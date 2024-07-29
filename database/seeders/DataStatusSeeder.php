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
            'kategori' => 'normal',
            'biaya_perbaikan' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('data_status')->insert([
            'nama_status' => 'Aset Diperbaiki',
            'color' => 'warning',
            'kategori' => 'rusak',
            'biaya_perbaikan' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('data_status')->insert([
            'nama_status' => 'Aset Rusak Ringan',
            'color' => 'warning',
            'kategori' => 'rusak',
            'biaya_perbaikan' => 0.25,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('data_status')->insert([
            'nama_status' => 'Aset Rusak Sedang',
            'color' => 'danger',
            'kategori' => 'rusak',
            'biaya_perbaikan' => 0.50,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('data_status')->insert([
            'nama_status' => 'Aset Rusak Berat',
            'color' => 'danger',
            'kategori' => 'rusak',
            'biaya_perbaikan' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        for ($i = 0; $i < 7; $i++) {
            DB::table('data_status')->insert([
                'nama_status' => 'Status ' . ($i + 1),
                'color' => 'primary',
                'kategori' => 'normal',
                'biaya_perbaikan' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
