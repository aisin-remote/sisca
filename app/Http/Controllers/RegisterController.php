<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    public function index ()
    {
        return view('auth.register');
    }

    public function store (Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'npk' => 'required|unique:users',
            'password' => ['required', Password::min(8)]
        ]);

        $request->validate([
            'password_confirmation' => 'required|same:password'
        ]);

        // cek password baru dan ulangi
        if($request->password != $request->password_confirmationd) {
            return back()->with('error', 'Password lama dan Ulangi Password tidak cocok');
        }

        $validatedData['password'] = Hash::make($validatedData['password']);

        User::create($validatedData);

        return redirect('/login') -> with('message', "Registrasi berhasil! Silahkan login");
    }
}
