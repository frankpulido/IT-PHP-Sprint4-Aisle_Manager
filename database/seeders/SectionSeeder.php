<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Section;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sections = [
            // Aisle 3
            ['aisle_id' => 2, 'aisle_order' => 1, 'kind' => 'water', 'number_products' => 4, 'grid_id' => 4],
            ['aisle_id' => 2, 'aisle_order' => 2, 'kind' => 'beer', 'number_products' => 6, 'grid_id' => 9],
            ['aisle_id' => 2, 'aisle_order' => 3, 'kind' => 'beer', 'number_products' => 6, 'grid_id' => 10],
            ['aisle_id' => 2, 'aisle_order' => 4, 'kind' => 'beverages', 'number_products' => 5, 'grid_id' => 8],
            ['aisle_id' => 2, 'aisle_order' => 5, 'kind' => 'beverages', 'number_products' => 5, 'grid_id' => 8],
            ['aisle_id' => 2, 'aisle_order' => 6, 'kind' => 'beverages', 'number_products' => 6, 'grid_id' => 9],
            ['aisle_id' => 2, 'aisle_order' => 7, 'kind' => 'dairy', 'number_products' => 4, 'grid_id' => 4],
            ['aisle_id' => 2, 'aisle_order' => 8, 'kind' => 'dairy', 'number_products' => 4, 'grid_id' => 5],

            // Aisle 5
            ['aisle_id' => 5, 'aisle_order' => 1, 'kind' => 'fresh food', 'number_products' => 9, 'grid_id' => 12],
            ['aisle_id' => 5, 'aisle_order' => 2, 'kind' => 'personal care', 'number_products' => 5, 'grid_id' => 8],
            ['aisle_id' => 5, 'aisle_order' => 3, 'kind' => 'cleaning', 'number_products' => 6, 'grid_id' => 9],
        ];

        foreach ($sections as $section) {
            Section::create($section);
        }

        Section::factory()->count(24)->create();
    }
}
?>