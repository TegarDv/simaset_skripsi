<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class LogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 10; $i++) {
            DB::table('log_activity')->insert([
                'id_user' => 1,
                'action' => 'tambah aset',
                'detail' => 'Ini detail ke ' . ($i + 1),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
