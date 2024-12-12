<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Section;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Section>
 */
class SectionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $kinds = ['food', 'fresh food', 'personal care', 'cleaning', 'dairy', 'beer', 'water', 'beverages'];
        // Important : database/migrations/2024_11_27_101432_create_sections_table.php must have matching enums

        $existentSectionLayouts = [1, 2, 3, 4, 5, 6, 8, 9, 10, 12, 15, 20];

        return [
            'kind' => $this->faker->randomElement($kinds),
            'number_products' => $this->faker->randomElement($existentSectionLayouts),
        ];
    }
}
?>