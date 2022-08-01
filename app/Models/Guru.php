<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
  use HasFactory;

  protected $table = 'guru';

  protected $fillable = [
    'nama_guru',
    'file_foto',
    'jenis_kelamin',
    'tempat_lahir',
    'tanggal_lahir',
    'nomor_induk',
    'nomor_telepon',
    'email',
    'password',
  ];
}
