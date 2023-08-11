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
            'password' => ['required', Password::min(8)->mixedCase()->letters()->numbers()->symbols()->uncompromised()]
        ]);

        $request->validate([
            'password_confirmation' => 'required|same:password'
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);

        User::create($validatedData);

        return redirect('/login') -> with('message', "Registrasi berhasil! Silahkan login");
    }
}
