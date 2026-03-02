<?php

namespace Database\Factories;

use App\Models\Gudang;
use App\Models\Supplier;
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
            "nama" => $this->faker->words(3, true),
            "harga" => $this->faker->randomFloat(2, 1000, 10000000),
            "jumlah" => 0,
            "gudang_id" => Gudang::inRandomOrder()->value("id")
                ?? Gudang::factory(),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function ($item) {
            $suppliers = Supplier::inRandomOrder()->take(rand(1, 3))->get();

            $totalJumlah = 0;
            foreach ($suppliers as $supplier) {
                $pivotJumlah = $this->faker->numberBetween(10, 200);

                $item->suppliers()->attach($supplier->id, [
                    'harga' => $this->faker->numberBetween(10000, 50000),
                    'jumlah' => $pivotJumlah,
                ]);

                $totalJumlah += $pivotJumlah;
            }

            $item->jumlah += $totalJumlah;
            $item->save();
        });
    }
}