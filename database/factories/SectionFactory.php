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
        // Randomly choose a kind
        //$kind = $this->faker->randomElement($kinds);

        // Random number of products (e.g., between 1 and 24 for the section)
        //$numberProducts = $this->faker->numberBetween(1, 24);

        // Create a random array of product IDs, ensure it doesn't exceed the number of products
        //$products = $this->faker->randomElements(range(1, 50), $numberProducts);

        return [
            'kind' => $this->faker->randomElement($kinds),
            'number_products' => $this->faker->numberBetween(1, 10),
            //'products' => null,
            //'php_layout' => null,  // For now, we leave it as null
        ];
    }
}
?>