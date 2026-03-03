<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DetailUserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "avatar" => null,
            "tgl_lahir" => $this->faker->date(),
            "alamat" => $this->faker->address(),
            "catatan" => $this->faker->paragraph(),
        ];
    }
}
