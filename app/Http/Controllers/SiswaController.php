<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class SiswaController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return view('siswa.index', [
      'kelas' => Kelas::all(),
      'siswa' => Siswa::all(),
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
      'nama_siswa' => ['required'],
      'jenis_kelamin' => ['required'],
      'tempat_lahir' => ['required'],
      'tanggal_lahir' => ['required'],
      'nomor_induk' => ['required', 'unique:siswa', 'unique:guru'],
      'nomor_telepon' => ['required', 'unique:siswa'],
      'email' => ['required', 'unique:siswa', 'unique:guru'],
      'password' => ['required'],
      'kelas_id' => ['required'],
    ]);

    if ($request->file('file_foto')) {
      $validatedData['file_foto'] = $request->file('file_foto')->store('foto-siswa');
    }

    $validatedData['password'] = Hash::make($validatedData['password']);

    Siswa::create($validatedData);

    User::create([
      'email' => $validatedData['email'],
      'role' => 'Siswa',
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
      'nama_siswa' => ['required'],
      'jenis_kelamin' => ['required'],
      'tempat_lahir' => ['required'],
      'tanggal_lahir' => ['required'],
      'nomor_induk' => ['required', Rule::unique('siswa')->ignore($id), Rule::unique('guru')],
      'nomor_telepon' => ['required', Rule::unique('siswa')->ignore($id)],
      'email' => ['required', Rule::unique('siswa')->ignore($id), 'unique:guru'],
      'password' => ['nullable'],
      'kelas_id' => ['required'],
    ]);

    $data = Siswa::find($id);
    $user = User::where('email', $data->email)->first();

    if ($request->file('file_foto')) {
      $validatedData['file_foto'] = $request->file('file_foto')->store('foto-siswa');
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
    $data = Siswa::find($id);
    $user = User::where('email', $data->email)->first();

    Siswa::destroy($id);
    User::destroy($user->id);

    return back()->with('success', 'Data Berhasil di Hapus!');
  }
}
