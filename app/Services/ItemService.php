<?php

namespace App\Services;

use App\Models\Item;
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
}