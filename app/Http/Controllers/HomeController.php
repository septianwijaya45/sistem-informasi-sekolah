<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Jadwal;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
  public function index()
  {
    $user = Auth::user();
    $hari = date('w');

    if (!$user->nomor_induk) return view('dashboard', ['jadwal' => []]);

    if ($user->role == 'Guru') {
      $guru = Guru::where('nomor_induk', $user->nomor_induk)->first();

      return view('dashboard', [
        'jadwal' => Jadwal::where('guru_id', $guru->id)->where('hari', $hari)->orderBy('jam_mulai', 'asc')->get(),
      ]);
    }

    $siswa = Siswa::where('nomor_induk', $user->nomor_induk)->first();

    return view('dashboard', [
      'jadwal' => Jadwal::where('kelas_id', $siswa->kelas_id)->where('hari', $hari)->orderBy('jam_mulai', 'asc')->get(),
    ]);
  }
}
