<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        "nama",
        "jumlah",
        "harga",
    ];

    protected function casts(): array
    {
        return [
            "harga" => "decimal:2",
            "jumlah" => "integer",
            "deleted_at" => "datetime",
        ];
    }

    
}