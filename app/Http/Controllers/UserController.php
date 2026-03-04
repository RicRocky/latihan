<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Wilayah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class UserController extends Controller
{
    public function profile()
    {
        return view("user/profile");
    }

    public function editAvatar(Request $request)
    {
        $this->validate($request, [
            'avatar' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user = auth()->user();

        if ($user->avatar) {
            Storage::disk('public')->delete($user->detailUser->avatar);
        }

        $path = $request->file('avatar')
            ->store('avatars', 'public');

        $user->detailUser->update([
            'avatar' => $path
        ]);

        return back()->with('success', 'Avatar updated!');
    }

    public function getAlamat(Request $request)
    {
        $validated = $request->validate([
            'kode_kelurahan' => 'required|string|min:8'
        ]);

        $kodeKelurahan = $validated['kode_kelurahan'];

        if (strlen($kodeKelurahan) < 8) {
            return response()->json([
                "error" => "Kode kelurahan harus 8 digit",
                "provinsi" => null,
                "kabupaten" => null,
                "kecamatan" => null,
                "kelurahan" => null
            ], 400);
        }

        try {
            $provinsi = Wilayah::where('kode', substr($kodeKelurahan, 0, 2))->value("nama");
            $kabupaten = Wilayah::where('kode', substr($kodeKelurahan, 0, 5))->value("nama");
            $kecamatan = Wilayah::where('kode', substr($kodeKelurahan, 0, 8))->value("nama");
            $kelurahan = Wilayah::where('kode', $kodeKelurahan)->value("nama");

            return response()->json([
                "provinsi" => $provinsi,
                "kabupaten" => $kabupaten,
                "kecamatan" => $kecamatan,
                "kelurahan" => $kelurahan
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "error" => "Terjadi kesalahan saat mengambil data alamat"
            ], 500);
        }
    }

    public function index(Request $request): View
    {
        $query = User::query();

        if ($request->filled("search")) {
            $query->where("name", "like", "%" . $request->search . "%");
        }

        $users = $query->with("detailUser")->latest()->paginate(10)->withQueryString();

        return view('user.index', [
            'users' => $users,
        ]);
    }

    public function edit(User $user): View
    {
        $provinsi = Wilayah::where("kode", "like", "__")->get();

        return view('user.edit', [
            'user' => $user,
            "provinsi" => $provinsi,
        ]);
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'tgl_lahir' => 'required|date',
            'kelurahan_id' => 'required|string|min:8',
            'alamat' => 'required|string|max:255',
            'catatan' => 'nullable|string',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        try {
            DB::transaction(function () use ($request, $user, $validated) {

                $user->update([
                    'name' => $validated['name'],
                ]);

                $dataDetail = [
                    'tgl_lahir' => $validated['tgl_lahir'],
                    'kelurahan_id' => $validated['kelurahan_id'],
                    'alamat' => $validated['alamat'],
                    'catatan' => $validated['catatan'] ?? null,
                ];

                if ($request->hasFile('avatar')) {

                    if ($user->detailUser?->avatar && Storage::disk('public')->exists($user->detailUser->avatar)) {
                        Storage::disk('public')->delete($user->detailUser->avatar);
                    }

                    $dataDetail['avatar'] = $request->file('avatar')->store('avatars', 'public');
                }

                $user->detailUser()->update($dataDetail);
            });

            return redirect()
                ->route('user.index')
                ->with('success', 'User berhasil diupdate');
        } catch (\Throwable $e) {
            return back()
                ->withInput()
                ->withErrors('Terjadi kesalahan saat mengubah data.');
        }
    }
}