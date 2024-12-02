<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Aisle;
use App\Models\Section;

class AisleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Aisle::factory(10)->create();
        /*
        Aisle::factory()->create([
            'name' => 'beverages',
            'sections' => ???,
        ]);
        */
        // Loop to create 8 aisles
        for ($i = 0; $i < 8; $i++) {
            Aisle::create([
                'name' => "Aisle " . ($i + 1),  // Set unique name for each aisle (e.g., Aisle 1, Aisle 2)
                'sections' => $this->generateSections(),  // Call a method to generate random sections
            ]);
        }
    }

    /**
     * Generate an array for the 'sections' field with 8 values.
     * Each value can be null or a random section id from the 'sections' table.
     */
    private function generateSections()
    {
        // Get an array of all section ids
        $sectionIds = Section::pluck('id')->toArray(); // Assume you have a Section model with an 'id' column
        
        // If no sections exist, just return an array of null values
        if (empty($sectionIds)) {
            return array_fill(0, 8, null);
        }

        // Generate 8 values, either null or a random section id
        return array_map(function () use ($sectionIds) {
            return rand(0, 1) ? $sectionIds[array_rand($sectionIds)] : null;
        }, range(1, 8));  // Generate 8 random values
    }
}
?>