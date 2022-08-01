<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    use HasFactory;
    protected $table = 'nilai_kuis';

    protected $fillable = [
        'id',
        'kuis_id',
        'siswa_id',
        'nilai',
        'created_at',
        'updated_at'
    ];
}
