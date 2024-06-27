<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AssetRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 10; $i++) {
            DB::table('permintaan_aset')->insert([
                'tipe_aset' => 'digital',
                'nama_aset' => 'Aset ' . ($i + 1),
                'harga' => 2570000,
                'spesifikasi' => 'ini spesifikasi',
                'keterangan' => 'ini keterangan',
                'stok_permintaan' => 17,
                'masa_berlaku' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
