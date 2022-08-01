<?php

namespace App\Http\Controllers;

use App\Models\AbsensiSiswa;
use App\Models\Guru;
use App\Models\Jadwal;
use App\Models\Materi;
use App\Models\Siswa;
use App\Models\Tugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AbsenController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $user = Auth::user();
    $hari = date('w');

    if (!$user->nomor_induk) return view('absen.index', [
      'user' => $user,
      'jadwal' => []
    ]);

    if ($user->role == 'Guru') {
      $guru = Guru::where('nomor_induk', $user->nomor_induk)->first();
      $jadwal = Jadwal::where('guru_id', $guru->id)->where('hari', $hari)->where('jam_mulai', '<=', now()->toTimeString())->where('jam_selesai', '>=', now()->toTimeString())->first();
      $siswa = $jadwal ? Siswa::where('kelas_id', $jadwal->kelas_id)->get() : [];
      $materi = $jadwal ? Materi::where('kelas_id', $jadwal->kelas_id)->where('mapel_id', $jadwal->mapel_id)->where('guru_id', $jadwal->guru_id)->where('tanggal', date('Y-m-d'))->get() : [];
      $tugas = $jadwal ? Tugas::where('kelas_id', $jadwal->kelas_id)->where('mapel_id', $jadwal->mapel_id)->where('guru_id', $jadwal->guru_id)->where('tanggal', date('Y-m-d'))->get() : [];

      return view('absen.index', [
        'user' => $user,
        'jadwal' => $jadwal,
        'materi' => $materi,
        'tugas' => $tugas,
        'siswa' => $siswa,
        'jam_mulai' => now()->addMinutes(-20)->toTimeString(),
        'jam_selesai' => now()->addMinutes(20)->toTimeString(),
      ]);
    }

    $siswa = Siswa::where('nomor_induk', $user->nomor_induk)->first();
    $jadwal = Jadwal::where('kelas_id', $siswa->kelas_id)->where('hari', $hari)->where('jam_mulai', '<=', now()->toTimeString())->where('jam_selesai', '>=', now()->toTimeString())->first();
    $materi = $jadwal ? Materi::where('kelas_id', $jadwal->kelas_id)->where('mapel_id', $jadwal->mapel_id)->where('guru_id', $jadwal->guru_id)->where('tanggal', date('Y-m-d'))->get() : [];
    $tugas = $jadwal ? Tugas::where('kelas_id', $jadwal->kelas_id)->where('mapel_id', $jadwal->mapel_id)->where('guru_id', $jadwal->guru_id)->where('tanggal', date('Y-m-d'))->get() : [];

    return view('absen.index', [
      'user' => $user,
      'jadwal' => $jadwal,
      'materi' => $materi,
      'tugas' => $tugas,
      'jam_mulai' => now()->addMinutes(-20)->toTimeString(),
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
      'status' => ['required'],
      'file' => ['nullable'],
      'jadwal_id' => ['required'],
    ]);

    $user = Auth::user();
    $siswa = Siswa::where('nomor_induk', $user->nomor_induk)->first();

    $validatedData['siswa_id'] = $siswa->id;
    $validatedData['tanggal'] = date('Y-m-d');

    if ($request->file('file')) {
      $validatedData['file'] = $request->file('file')->store('file-izin');
      $validatedData['nama_file'] = $validatedData['tanggal'] . ' - ' . $siswa->nama_siswa . '.' . $request->file('file')->getClientOriginalExtension();
    }

    AbsensiSiswa::create($validatedData);

    return back();
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    $absensi = AbsensiSiswa::find($id);

    return Storage::download($absensi->file, $absensi->nama_file);
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
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    //
  }
}
