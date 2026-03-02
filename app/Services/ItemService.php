<?php

namespace App\Services;

use App\Models\Item;
use App\Models\Supplier;
use Illuminate\Support\Facades\DB;

class ItemService
{
    public function create(array $data): Item
    {
        return DB::transaction(function () use ($data) {
            $item = Item::create($data);

            return $item;
        });
    }

    public function update(array $data): Item
    {
        return DB::transaction(function () use ($data) {
            $data["item"]->update($data["validated"]);
        });
    }

    public function attach(
        Supplier $supplier,
        Item $item,
        float $harga,
        int $jumlah
    ): void {
        DB::transaction(function () use ($supplier, $item, $harga, $jumlah) {
            $supplier->items()->attach($item->id, [
                'harga' => $harga,
                'jumlah' => $jumlah,
            ]);

            $item->increment('jumlah', $jumlah);
        });
    }

}