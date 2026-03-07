<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled("search")) {
            $query->where("name", "like", "%" . $request->search . "%");
        }

        $users = $query->with("detailUser")->latest()->paginate(10)->withQueryString();

        return response()->json([
            "msg" => "success",
            "data" => $users
        ]);
    }

}
