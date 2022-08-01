<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materi extends Model
{
    use HasFactory;

    protected $table = 'materi';

    protected $fillable = [
        'nama_materi',
        'nama_file_materi',
        'file_materi',
        'tanggal',
        'kelas_id',
        'mapel_id',
        'guru_id',
    ];
}
