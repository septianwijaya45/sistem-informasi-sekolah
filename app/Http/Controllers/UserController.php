<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return view('user.index', [
      'user' => User::all(),
    ]);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $validatedData = $request->validate([
      'email' => ['required', 'email', 'unique:users'],
      'role' => ['required'],
      'nomor_induk' => ['required', $request->role === 'Guru' ? 'exists:guru,nomor_induk' : 'exists:siswa,nomor_induk'],
      'password' => ['required'],
    ]);

    $validatedData['password'] = Hash::make($validatedData['password']);

    User::create($validatedData);

    return back()->with('success', 'Data Berhasil di Tambah!');
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    $validatedData = $request->validate([
      'email' => ['required', 'email', Rule::unique('users')->ignore($id)],
      'role' => ['required'],
      'nomor_induk' => ['required', $request->role === 'Guru' ? 'exists:guru,nomor_induk' : 'exists:siswa,nomor_induk'],
      'password' => ['nullable'],
    ]);

    $data = User::find($id);

    if (isset($validatedData['password'])) $validatedData['password'] = Hash::make($validatedData['password']);

    $data->update($validatedData);

    return back()->with('success', 'Data Berhasil di Edit!');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    User::destroy($id);

    return back()->with('success', 'Data Berhasil di Hapus!');
  }
}
