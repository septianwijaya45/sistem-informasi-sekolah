<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
  public function loginView()
  {
    return view('auth.login');
  }

  public function loginLogic(Request $request)
  {
    $validated = $request->validate([
      'email' => ['required', 'email'],
      'password' => ['required'],
    ]);

    if (Auth::attempt($validated)) {
      $request->session()->regenerate();

      return redirect()->intended('dashboard');
    }

    return back()->with([
      'error' => 'Login Gagal',
    ]);
  }

  public function registerView()
  {
    return view('auth.register');
  }

  public function registerLogic(Request $request)
  {
    $validatedData = $request->validate([
      'email' => ['required', 'email', 'unique:users'],
      'role' => ['required'],
      'nomor_induk' => ['required', $request->role === 'Guru' ? 'exists:guru,nomor_induk' : 'exists:siswa,nomor_induk'],
      'password' => ['required'],
    ]);

    $validatedData['password'] = Hash::make($validatedData['password']);

    User::create($validatedData);

    return redirect('/login')->with('success', 'Registrasi User Berhasil!');
  }

  public function logoutLogic(Request $request)
  {
    Auth::logout();

    $request->session()->invalidate();

    $request->session()->regenerateToken();

    return redirect('/');
  }
}
