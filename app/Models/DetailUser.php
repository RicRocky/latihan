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
        "kelurahan_id",
        "alamat",
        "catatan",
    ];

    protected $casts = [
        'tgl_lahir' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getWilayahAttribute()
    {
        if (!$this->kelurahan_id) {
            return null;
        }

        $kode = $this->kelurahan_id;

        return [
            "provinsi" => Wilayah::where('kode', substr($kode, 0, 2))->value("nama"),
            "kota" => Wilayah::where('kode', substr($kode, 0, 5))->value("nama"),
            "kecamatan" => Wilayah::where('kode', substr($kode, 0, 8))->value("nama"),
            "kelurahan" => Wilayah::where('kode', $kode)->value("nama"),
        ];
    }
}