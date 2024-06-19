<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            AssetLocationSeeder::class,
            DataStatusSeeder::class,
            UserRoleSeeder::class,
            UserSeeder::class,
            AssetsSeeder::class,
            LogSeeder::class,
            TransactionSeeder::class,
        ]);
    }
}
