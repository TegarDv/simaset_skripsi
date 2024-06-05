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
                'tipe_aset' => 'digital',
                'kode_aset' => $kodeAset,
                'nama_aset' => 'Aset ' . ($i + 1),
                'jumlah' => '10',
                'harga' => 2570000,
                'spesifikasi' => 'ini spesifikasi',
                'keterangan' => 'ini keterangan',
                'stok_awal' => 10,
                'stok_sekarang' => 10,
                'masa_berlaku' => now(),
                'tanggal_penerimaan' => now(),
                'status_aset' => 1,
                'kondisi_aset' => 1,
                'lokasi_aset' => 1,
                'id_user' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
