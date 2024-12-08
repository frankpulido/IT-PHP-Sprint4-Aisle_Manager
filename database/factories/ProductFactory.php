<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;
use App\Models\GridLayout;
use App\Models\Section;
use App\Models\Aisle;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Product::class;

    public function definition(): array
    {
        // Define possible kinds of products as per the ENUM in migration
        $kinds = ['food', 'fresh food', 'personal care', 'cleaning', 'dairy', 'beer', 'water', 'beverages'];

        // Generate a random product kind
        $kind = $this->faker->randomElement($kinds);

        // Generate a random product name based on kind
        $name = $this->faker->word();

        // Generate a random price (for example, $1 to $100)
        $price = $this->faker->randomFloat(2, 1, 20);

        return [
            'name' => $name,
            'kind' => $kind,
            'price' => number_format($price, 2, '.', ''), // migration use "decimal", it is supposed to cast it, but just in case
        ];
    }
}
?>