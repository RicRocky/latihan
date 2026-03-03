<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailUser extends Model
{
    use HasFactory;

    protected $fillable = [
        "user_id",
        "avatar",
        "tgl_lahir",
        "provinsi",
        "kota",
        "kecamatan",
        "kelurahan",
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    } 
}