<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Wilayah;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $provinsi = Wilayah::where("kode", "like", "__")->get();
        return view('auth.register', compact("provinsi"));
    }

    public function getKota(Request $request)
    {
        $validated = $request->validate([
            'kodeProvinsi' => 'required|string|size:2'
        ]);

        $kota = Wilayah::where("kode", "like", $validated["kodeProvinsi"] . "___")->get();
        return response()->json([
            "msg" => "success",
            "data" => $kota
        ], 200);
    }

    public function getKecamatan(Request $request)
    {
        $validated = $request->validate([
            'kodeKota' => 'required|string|size:5'
        ]);

        $kecamatan = Wilayah::where("kode", "like", $validated["kodeKota"] . "___")->get();
        return response()->json([
            "msg" => "success",
            "data" => $kecamatan
        ], 200);
    }

    public function getDesa(Request $request)
    {
        $validated = $request->validate([
            'kodeKecamatan' => 'required|string|size:8'
        ]);

        $desa = Wilayah::where("kode", "like", $validated["kodeKecamatan"] . "_____")->get();
        return response()->json([
            "msg" => "success",
            "data" => $desa
        ], 200);
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            "provinsi" => ['required', 'string'],
            "kota" => ['required', 'string'],
            "kecamatan" => ['required', 'string'],
            "kelurahan" => ['required', 'string'],
            "detail_alamat" => ["required", 'string'],
            "catatan" => ['string'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->detailUser()->create([
            "kelurahan_id" => $request->kelurahan,
            "alamat" => $request->detail_alamat,
            "catatan" => $request->catatan,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
