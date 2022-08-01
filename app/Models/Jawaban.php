<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jawaban extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'pertanyaan_id',
        'nomor_induk',
        'jawaban',
        'cek_jawaban',
        'created_at',
        'updated_at'
    ];
}
