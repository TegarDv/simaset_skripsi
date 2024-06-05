<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AssetLocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('asset_location')->insert([
            'location' => 'Ruang Server',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('asset_location')->insert([
            'location' => 'Ruang Dosen',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('asset_location')->insert([
            'location' => 'Ruang Kelas',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
