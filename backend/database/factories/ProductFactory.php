<?php

namespace Database\Factories;

use App\Models\Subcategory;
use Illuminate\Database\Eloquent\Factories\Factory;

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
    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'logo' => $this->faker->image,
            'qty' => $this->faker->numberBetween([20,300]),
            'price' => $this->faker->randomNumber([1000, 10000]),
            'description' => $this->faker->sentence,
            'subcategory_id' => \App\Models\Subcategory::inRandomOrder()->first()->id,
            'brand_id' => \App\Models\Brand::inRandomOrder()->first()->id,
        ];
    }
}
