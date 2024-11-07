<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    public function index()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'name' => 'required',
            'npk' => 'required|unique:users',
            'password' => ['required', Password::min(8)],
            'role' => 'required|in:User,MTE', // Menambahkan validasi role
        ]);

        // Validasi konfirmasi password
        $request->validate([
            'password_confirmation' => 'required|same:password'
        ]);

        // Hash password
        $validatedData['password'] = Hash::make($validatedData['password']);

        // Simpan data user ke database
        User::create($validatedData);

        // Redirect ke halaman login dengan pesan sukses
        return redirect('/login')->with('message', "Registrasi berhasil! Silahkan login");
    }
}
