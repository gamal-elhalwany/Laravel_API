<?php

namespace Database\Factories;
use App\Models\User;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Testing\Fakes\Fake;

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
            'name' => $this->faker->name(),
            'detail' => $this->faker->paragraph(),
            'price' => $this->faker->numberBetween(100,1000),
            'stock' => $this->faker->randomDigit(),
            'discount' => $this->faker->numberBetween(5,30),
            'user_id' => function () {
                return User::all()->random();
            },
        ];
    }
}
