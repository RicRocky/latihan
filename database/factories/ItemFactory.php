<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "nama" => $this->faker->name(),
            "jumlah" => $this->faker->numberBetween(0, 1000),
            "harga" => $this->faker->randomFloat(2, 1000, 10000000),
        ];
    }

    public function outOfStock()
    {
        return $this->state(function (array $attributes) {
            return [
                "jumlah" => 0
            ];
        });
    }
}