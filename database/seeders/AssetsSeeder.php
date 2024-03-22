<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AssetsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 10; $i++) {
            $formattedCounter = sprintf('%03d', $i + 1); // Formats the counter as three-digit with leading zeros
            $kodeAset = 'DG-KWT9-' . $formattedCounter;

            DB::table('assets')->insert([
                'id_user' => '1',
                'tipe_aset' => 'digital',
                'kode_aset' => $kodeAset,
                'nama_aset' => 'Aset ' . ($i + 1),
                'jumlah' => '10',
                'harga' => 2570000,
                'spesifikasi' => 'ini spesifikasi',
                'keterangan' => 'ini keterangan',
                'status' => '1',
                'kondisi_aset' => '1',
                'masa_berlaku' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
