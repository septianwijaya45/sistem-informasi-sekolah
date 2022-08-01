<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Jadwal;
use App\Models\Kelas;
use App\Models\Mapel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JadwalController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return view('jadwal.index', [
      'user' => Auth::user(),
      'hari' => [
        'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'
      ],
      'jadwal' => Jadwal::orderBy('hari', 'asc')->orderBy('jam_mulai', 'asc')->get(),
      'kelas' => Kelas::all(),
      'mapel' => Mapel::all(),
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
      'hari' => ['required'],
      'kelas_id' => ['required'],
      'mapel_id' => ['required'],
      'guru_id' => ['required'],
      'jam_mulai' => ['required'],
      'jam_selesai' => ['required'],
    ]);

    Jadwal::create($validatedData);

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
      'hari' => ['required'],
      'kelas_id' => ['required'],
      'mapel_id' => ['required'],
      'guru_id' => ['required'],
      'jam_mulai' => ['required'],
      'jam_selesai' => ['required'],
    ]);

    $data = Jadwal::find($id);
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
    Jadwal::destroy($id);

    return back()->with('success', 'Data Berhasil di Hapus!');
  }
}
