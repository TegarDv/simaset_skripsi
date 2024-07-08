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
        // Super Admin Trx
        for ($i = 0; $i < 5; $i++) {
            $formattedCounter = sprintf('%03d', $i + 1); // Formats the counter as three-digit with leading zeros
            $kodeAset = 'TRX-PMJ-1' . $formattedCounter;

            DB::table('transkasi_aset')->insert([
                'asset_id' => $i + 1,
                'user_id' => 1,
                'tipe_transaksi' => 'peminjaman',
                'kode_transaksi' => $kodeAset,
                'stok' => 10 - $i,
                'stok_sebelum' => 10 - $i,
                'stok_sesudah' => $i,
                'keterangan' => 'Ini keterangan ' . ($i + 1),
                'tanggal_transaksi' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        for ($i = 0; $i < 5; $i++) {
            $formattedCounter = sprintf('%03d', $i + 1); // Formats the counter as three-digit with leading zeros
            $kodeAset = 'TRX-PNG-1' . $formattedCounter;

            DB::table('transkasi_aset')->insert([
                'asset_id' => $i + 1,
                'user_id' => 1,
                'tipe_transaksi' => 'pengembalian',
                'kode_transaksi' => $kodeAset,
                'stok' => 10 - $i,
                'stok_sebelum' => 10 - $i,
                'stok_sesudah' => $i,
                'keterangan' => 'Ini keterangan ' . ($i + 1),
                'tanggal_transaksi' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Admin Trx
        for ($i = 0; $i < 5; $i++) {
            $formattedCounter = sprintf('%03d', $i + 1); // Formats the counter as three-digit with leading zeros
            $kodeAset = 'TRX-PMJ-2' . $formattedCounter;

            DB::table('transkasi_aset')->insert([
                'asset_id' => $i + 1,
                'user_id' => 2,
                'tipe_transaksi' => 'peminjaman',
                'kode_transaksi' => $kodeAset,
                'stok' => 10 - $i,
                'stok_sebelum' => 10 - $i,
                'stok_sesudah' => $i,
                'keterangan' => 'Ini keterangan ' . ($i + 1),
                'tanggal_transaksi' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        for ($i = 0; $i < 5; $i++) {
            $formattedCounter = sprintf('%03d', $i + 1); // Formats the counter as three-digit with leading zeros
            $kodeAset = 'TRX-PNG-2' . $formattedCounter;

            DB::table('transkasi_aset')->insert([
                'asset_id' => $i + 1,
                'user_id' => 2,
                'tipe_transaksi' => 'pengembalian',
                'kode_transaksi' => $kodeAset,
                'stok' => 10 - $i,
                'stok_sebelum' => 10 - $i,
                'stok_sesudah' => $i,
                'keterangan' => 'Ini keterangan ' . ($i + 1),
                'tanggal_transaksi' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // User Trx
        for ($i = 0; $i < 5; $i++) {
            $formattedCounter = sprintf('%03d', $i + 1); // Formats the counter as three-digit with leading zeros
            $kodeAset = 'TRX-PMJ-3' . $formattedCounter;

            DB::table('transkasi_aset')->insert([
                'asset_id' => $i + 1,
                'user_id' => 3,
                'tipe_transaksi' => 'peminjaman',
                'kode_transaksi' => $kodeAset,
                'stok' => 10 - $i,
                'stok_sebelum' => 10 - $i,
                'stok_sesudah' => $i,
                'keterangan' => 'Ini keterangan ' . ($i + 1),
                'tanggal_transaksi' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        for ($i = 0; $i < 5; $i++) {
            $formattedCounter = sprintf('%03d', $i + 1); // Formats the counter as three-digit with leading zeros
            $kodeAset = 'TRX-PNG-3' . $formattedCounter;

            DB::table('transkasi_aset')->insert([
                'asset_id' => $i + 1,
                'user_id' => 3,
                'tipe_transaksi' => 'pengembalian',
                'kode_transaksi' => $kodeAset,
                'stok' => 10 - $i,
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
