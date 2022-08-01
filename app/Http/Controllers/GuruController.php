<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class GuruController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return view('guru.index', [
      'guru' => Guru::all(),
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
      'file_foto' => ['nullable', 'image'],
      'nama_guru' => ['required'],
      'jenis_kelamin' => ['required'],
      'tempat_lahir' => ['required'],
      'tanggal_lahir' => ['required'],
      'nomor_induk' => ['required', 'unique:guru', 'unique:siswa'],
      'nomor_telepon' => ['required', 'unique:guru'],
      'email' => ['required', 'unique:siswa', 'unique:guru'],
      'password' => ['required'],
    ]);

    if ($request->file('file_foto')) {
      $validatedData['file_foto'] = $request->file('file_foto')->store('foto-guru');
    }

    $validatedData['password'] = Hash::make($validatedData['password']);

    Guru::create($validatedData);

    User::create([
      'email' => $validatedData['email'],
      'role' => 'Guru',
      'nomor_induk' => $validatedData['nomor_induk'],
      'password' => $validatedData['password'],
    ]);

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
      'file_foto' => ['nullable', 'image'],
      'nama_guru' => ['required'],
      'jenis_kelamin' => ['required'],
      'tempat_lahir' => ['required'],
      'tanggal_lahir' => ['required'],
      'nomor_induk' => ['required', Rule::unique('guru')->ignore($id), Rule::unique('siswa')],
      'nomor_telepon' => ['required', Rule::unique('guru')->ignore($id)],
      'email' => ['required', Rule::unique('guru')->ignore($id), 'unique:siswa'],
      'password' => ['nullable'],
    ]);

    $data = Guru::find($id);
    $user = User::where('email', $data->email)->first();

    if ($request->file('file_foto')) {
      $validatedData['file_foto'] = $request->file('file_foto')->store('foto-guru');
    } else {
      $validatedData['file_foto'] = $data->file_foto;
    }

    if ($validatedData['password']) {
      $validatedData['password'] = Hash::make($validatedData['password']);
    } else {
      $validatedData['password'] = $data->password;
    }

    $data->update($validatedData);

    $user->update([
      'email' => $validatedData['email'],
      'password' => $validatedData['password']
    ]);

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
    $data = Guru::find($id);
    $user = User::where('email', $data->email)->first();

    Guru::destroy($id);
    User::destroy($user->id);

    return back()->with('success', 'Data Berhasil di Hapus!');
  }
}
