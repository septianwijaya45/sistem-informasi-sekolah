<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
  use HasFactory;

  protected $table = 'siswa';

  protected $fillable = [
    'nama_siswa',
    'file_foto',
    'jenis_kelamin',
    'tempat_lahir',
    'tanggal_lahir',
    'nomor_induk',
    'nomor_telepon',
    'email',
    'password',
    'kelas_id',
  ];

  public function kelas()
  {
    return $this->belongsTo(Kelas::class);
  }
}
