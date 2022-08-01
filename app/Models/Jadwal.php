<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Jadwal extends Model
{
  use HasFactory;

  protected $table = 'jadwal';

  protected $fillable = [
    'hari',
    'kelas_id',
    'mapel_id',
    'guru_id',
    'jam_mulai',
    'jam_selesai',
  ];

  public function kelas()
  {
    return $this->belongsTo(Kelas::class);
  }

  public function mapel()
  {
    return $this->belongsTo(Mapel::class);
  }

  public function guru()
  {
    return $this->belongsTo(Guru::class);
  }

  public function absensi()
  {
    $user = Auth::user();

    if ($user->role == 'Guru') {
      return $this->hasMany(AbsensiSiswa::class)->where('jadwal_id', $this->id)->where('tanggal', date('Y-m-d'));
    }

    $siswa = Siswa::where('nomor_induk', $user->nomor_induk)->first();

    return $this->hasMany(AbsensiSiswa::class)->where('jadwal_id', $this->id)->where('siswa_id', $siswa->id)->where('tanggal', date('Y-m-d'));
  }
}
