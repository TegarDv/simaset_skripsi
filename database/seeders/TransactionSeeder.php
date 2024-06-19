<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 10; $i++) {
            $formattedCounter = sprintf('%03d', $i + 1); // Formats the counter as three-digit with leading zeros
            $kodeAset = 'TRX-PMJ-' . $formattedCounter;

            DB::table('transkasi_aset')->insert([
                'asset_id' => $i + 1,
                'user_id' => $i + 1,
                'tipe_transaksi' => 'peminjaman',
                'kode_transaksi' => $kodeAset,
                'stok_sebelum' => 10 - $i,
                'stok_sesudah' => $i,
                'keterangan' => 'Ini keterangan ' . ($i + 1),
                'tanggal_transaksi' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        for ($i = 0; $i < 10; $i++) {
            $formattedCounter = sprintf('%03d', $i + 1); // Formats the counter as three-digit with leading zeros
            $kodeAset = 'TRX-PNG-' . $formattedCounter;

            DB::table('transkasi_aset')->insert([
                'asset_id' => $i + 1,
                'user_id' => $i + 1,
                'tipe_transaksi' => 'pengembalian',
                'kode_transaksi' => $kodeAset,
                'stok_sebelum' => 10 - $i,
                'stok_sesudah' => $i,
                'keterangan' => 'Ini keterangan ' . ($i + 1),
                'tanggal_transaksi' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
