<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransactionRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 3; $i++) {
            DB::table('request_peminjaman_aset')->insert([
                'asset_id' => $i + 1,
                'user_id' => 1,
                'jumlah' => 10 - $i,
                'keterangan' => 'Ini keterangan ' . ($i + 1),
                'tanggal_permintaan' => now(),
                'status_permintaan' => 'pending',
                'catatan_permintaan' => 'sedang ditinjau',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        for ($i = 0; $i < 2; $i++) {
            DB::table('request_peminjaman_aset')->insert([
                'asset_id' => $i + 1,
                'user_id' => 1,
                'jumlah' => 10 - $i,
                'keterangan' => 'Ini keterangan ' . ($i + 1),
                'tanggal_permintaan' => now(),
                'status_permintaan' => 'ditolak',
                'catatan_permintaan' => 'Aset sedang rusak',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        DB::table('request_peminjaman_aset')->insert([
            'asset_id' => 1,
            'user_id' => 1,
            'jumlah' => 1,
            'keterangan' => 'Ini keterangan ',
            'tanggal_permintaan' => now(),
            'status_permintaan' => 'disetujui',
            'catatan_permintaan' => 'Barang bisa diambil di xxx',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
