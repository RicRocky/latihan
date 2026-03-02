<?php

namespace App\Services;

use App\Models\Supplier;
use Illuminate\Support\Facades\DB;

class SupplierService
{
    public function create(array $data): Supplier
    {
        return DB::transaction(function () use ($data) {
            $supplier = Supplier::create($data);

            return $supplier;
        });
    }

    public function update(array $data): Supplier
    {
        return DB::transaction(function () use ($data) {
            $data["supplier"]->update($data["validated"]);
        });
    }
}