<?php

namespace Database\Seeders;

use App\Models\Gudang;
use App\Models\Item;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->count(10)->create();
        Gudang::factory()->count(15)->create();
        $this->call(SupplierSeeder::class);
        Item::factory()->count(100)->create();
    }
}
