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
            "provinsi" => $this->faker->word(),
            "kota" => $this->faker->word(),
            "kecamatan" => $this->faker->word(),
            "kelurahan" => $this->faker->word(),
            "catatan" => $this->faker->paragraph(),
        ];
    }
}
