<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengumpulanTugas extends Model
{
  use HasFactory;

  protected $table = 'pengumpulan_tugas';

  protected $fillable = [
    'tugas_id',
    'siswa_id',
    'nama_file_tugas',
    'file_tugas',
    'nilai',
  ];
}
