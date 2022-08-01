<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbsensiSiswa extends Model
{
  use HasFactory;

  protected $table = 'absensi_siswa';

  protected $fillable = [
    'siswa_id',
    'jadwal_id',
    'status',
    'tanggal',
    'file',
    'nama_file',
  ];
}
