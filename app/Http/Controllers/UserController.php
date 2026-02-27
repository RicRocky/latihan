<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            Storage::disk('public')->delete($user->avatar);
        }

        $path = $request->file('avatar')
            ->store('avatars', 'public');

        $user->update([
            'avatar' => $path
        ]);

        return back()->with('success', 'Avatar updated!');
    }
}