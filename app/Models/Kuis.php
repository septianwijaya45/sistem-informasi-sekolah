<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kuis extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'mapel_id',
        'jadwal_id',
        'guru_id',
        'judul_kuis',
        'created_at',
        'updated_at'
    ];
}
