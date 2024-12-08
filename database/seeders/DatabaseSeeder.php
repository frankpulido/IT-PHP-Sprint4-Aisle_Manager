<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Aisle;
use App\Models\Section;
use App\Models\Product;
use App\Models\GridLayout;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            AisleSeeder::class,
            GridLayoutSeeder::class,
            SectionSeeder::class,
            ProductSeeder::class, // Order is important (products go inside sections that go inside aisles) / Inverse order than migrations
        ]);
        /* User::factory(10)->create();
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        */
    }
}
