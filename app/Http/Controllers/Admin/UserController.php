<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::with("detailUser")->latest()->get();

        ///////////////////////////////
        // Pengaturan table frontend //
        ///////////////////////////////
        $heads = [
            'No',
            'Profile',
            __("user.nama"),
            'Email',
            __("user.tgl_lahir"),
            __("user.alamat"),
            __("user.catatan"),
            __("user.provinsi"),
            __("user.kota"),
            __("user.kecamatan"),
            __("user.desa"),
            ['label' => __("support.aksi"), 'no-export' => true, 'width' => 5],
        ];

        $data = [];

        foreach ($users as $i => $user) {

            $avatar = '<img src="' . (
                $user->detailUser->avatar
                ? Storage::url($user->detailUser->avatar)
                : asset('default-avatar.png')
            ) . '" class="img-circle img-size-32">';

            $btnEdit = '<button class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit">
                        <i class="fa fa-lg fa-fw fa-pen"></i>
                    </button>';

            $btnDelete = '<form action="' . route("admin.user.delete") . '" method="POST" style="display:inline;">
                        ' . csrf_field() . '
                        ' . method_field("DELETE") . '
                        <input type="hidden" name="user_id" value="' . $user->id . '">
                        <button class="btn btn-xs btn-default text-danger mx-1 shadow" title="Delete">
                            <i class="fa fa-lg fa-fw fa-trash"></i>
                        </button>
                      </form>';

            $data[] = [
                $i + 1,
                $avatar,
                $user->name,
                $user->email,
                $user->detailUser->tgl_lahir->format('d-m-Y'),
                $user->detailUser->alamat,
                $user->detailUser->catatan,
                $user->detailUser->wilayah['provinsi'],
                $user->detailUser->wilayah['kota'],
                $user->detailUser->wilayah['kecamatan'],
                $user->detailUser->wilayah['kelurahan'],
                '<nobr>' . $btnEdit . $btnDelete . '</nobr>',
            ];
        }

        $config = [
            'data' => $data,
            'order' => [[0, 'asc']],
            'columns' => [
                null,
                ['orderable' => false],
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                ['orderable' => false]
            ],
        ];

        return view("adminlte.users.index", compact("heads", "config"));
    }

    public function delete(Request $request)
    {
        try {
            $user = User::findOrFail($request->user_id);
            $user->detailUser()->delete();
            $user->delete();

            return redirect()->route("admin.users")->with("success", "User berhasil dihapus.");
        } catch (\Exception $e) {
            return redirect()->route("admin.users")->with("error", "Gagal menghapus user: " . $e->getMessage());
        }
    }
}