<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pertanyaan extends Model
{
    use HasFactory;
    protected $fillable = [
        'kuis_id',
        'pertanyaan',
        'opsi1',
        'opsi2',
        'opsi3',
        'opsi4',
        'opsi5',
        'jawaban',
        'created_at',
        'updated_at'
    ];
}
