<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function index()
    {
        return view('dashboard.profile.index');
    }

    public function changePassword(Request $request)
    {
        $user = auth()->user();
        // cek password lama
        if(!Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Password lama tidak cocok dengan password anda saat ini');
        }

        // cek password baru dan ulangi
        if($request->passwordBaru != $request->ulangiPassword) {
            return back()->with('error', 'Password lama dan Ulangi Password tidak cocok');
        }

        $request->validate([
            'passwordBaru' => ['required', Password::min(8)->mixedCase()->letters()->numbers()->symbols()->uncompromised()],
            'ulangiPassword' => ['required']
        ]);

        $user->update([
            'password' => Hash::make($request->passwordBaru)
        ]);

        Auth::logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect('/login')->with('success', 'Password berhasil diubah');
    }
}
