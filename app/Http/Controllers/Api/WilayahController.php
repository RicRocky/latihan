<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Wilayah;
use Illuminate\Http\Request;

class WilayahController extends Controller
{
    public function getKotaApi($id)
    {
        $kota = Wilayah::where("kode", "like", $id . "___")->get();

        return response()->json([
            "msg" => "success",
            "data" => $kota
        ]);
    }
}