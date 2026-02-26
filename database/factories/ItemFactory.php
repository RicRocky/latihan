<?php

namespace Database\Factories;

use App\Models\Gudang;
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
            "gudang_id" => Gudang::inRandomOrder()->value("id")
                ?? Gudang::factory(),
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