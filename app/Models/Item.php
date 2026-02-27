<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        "nama",
        "jumlah",
        "harga",
        "gudang_id",
    ];
    
    protected $with = ['gudang'];

    protected function casts(): array
    {
        return [
            "harga" => "decimal:2",
            "jumlah" => "integer",
            "deleted_at" => "datetime",
        ];
    }

    public function gudang(): BelongsTo
    {
        return $this->belongsTo(Gudang::class)->withTrashed();
    }
}