<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Section;
use App\Models\Product;
use Faker\Factory as Faker;


class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Loop through all sections
        Section::all()->each(function ($section) use ($faker) {
            // If section belongs to an aisle, create products based on the section's attributes
            if ($section->aisle_id) {
                for ($i = 1; $i <= $section->number_products; $i++) {
                    Product::create([
                        'section_id' => $section->id,  // Section ID from the current section
                        'section_order' => $i,         // Section order incremented from 1 to number_products
                        'name' => $faker->word(),      // Random product name
                        'kind' => $section->kind,      // Product kind (from the section)
                        'price' => $faker->randomFloat(2, 1, 100), // Random price
                        'revenues_year' => $faker->randomFloat(2, 80000, 200000),
                        'turnover_year' => $faker->randomFloat(2, 0, 20),
                        'stockouts_year' => $faker->randomElement([0, 0, 0, 1, 2]), // 90% chance of being 0
                    ]);
                }
            }

            // If section does not belong to an aisle (orphaned section)
            if (!$section->aisle_id) {
                for ($i = 1; $i <= $section->number_products; $i++) {
                    Product::create([
                        'section_id' => $section->id,  // Section ID from the current section
                        'section_order' => $i,         // Section order incremented from 1 to number_products
                        'name' => $faker->word(),      // Random product name
                        'kind' => $section->kind,      // Product kind (from the section)
                        'price' => $faker->randomFloat(2, 1, 100), // Random price
                    ]);
                }
            }
        });

        Product::factory(100)->create();

    }
}
