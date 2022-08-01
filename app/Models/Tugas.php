<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Tugas extends Model
{
    use HasFactory;

    protected $table = 'tugas';

    protected $fillable = [
        'nama_tugas',
        'nama_file_tugas',
        'file_tugas',
        'tanggal',
        'tanggal_deadline',
        'jam_deadline',
        'kelas_id',
        'mapel_id',
        'guru_id',
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function mapel()
    {
        return $this->belongsTo(Mapel::class);
    }

    public function pengumpulan()
    {
        $user = Auth::user();
        $siswa = Siswa::where('nomor_induk', $user->nomor_induk)->first();

        return $this->hasMany(PengumpulanTugas::class)->where('siswa_id', $siswa->id);
    }
}
