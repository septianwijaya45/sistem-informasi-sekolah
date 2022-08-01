<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Jadwal;
use App\Models\Jawaban;
use App\Models\Kelas;
use App\Models\Kuis;
use App\Models\Mapel;
use App\Models\Nilai;
use App\Models\Pertanyaan;
use App\Models\Siswa;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KuisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->role == 'Guru'){
            $kuis = Kuis::all();
            $mapel = Mapel::all();
            $kelas = Kelas::all();
            $guru = Guru::all();
            return view('kuis.guru.index', compact(['kuis', 'mapel', 'kelas', 'guru']));
        }else{
            $kuis = Kuis::all();
            $siswa = Siswa::where('nomor_induk', Auth::user()->nomor_induk)->first();
            return view('kuis.siswa.index', compact(['kuis', 'siswa']));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Auth::user()->role == 'Guru'){
            // get Jadwal
            $jadwal = Jadwal::where([
                ['kelas_id', $request->kelas_id],
                ['mapel_id', $request->kelas_id],
                ['guru_id', $request->guru_id]
            ])->first();

            if(empty($jadwal)){
                return back()->with('failed', 'Data Gagal di Tambah! Guru Dengan Jadwal tersebut tidak ada!');
            }else{
                // Tambah Kuis
    
                Kuis::insert([
                    'mapel_id'      => $request->mapel_id,
                    'kelas_id'      => $request->kelas_id,
                    'jadwal_id'     => $jadwal->id,
                    'guru_id'       => $request->guru_id,
                    'judul_kuis'    => $request->judul_kuis,
                    'created_at'    => Carbon::now(),
                    'updated_at'    => Carbon::now()
                ]);
    
                return back()->with('success', 'Data Berhasil di Tambah!');
            }

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(Auth::user()->role == 'Guru'){
            $kuis = DB::select("
                SELECT m.nama_mapel, k.nama_kelas, g.nama_guru, j.*, ku.judul_kuis, ku.id, ku.guru_id, ku.mapel_id, ku.kelas_id
                FROM mapel m, kelas k, guru g, kuis ku, jadwal j
                WHERE ku.id = $id AND ku.mapel_id = m.id AND ku.kelas_id = k.id AND ku.guru_id = g.id
                GROUP BY ku.id
            ");
            foreach($kuis as $kuis){
                $kuis;
            }

            $nilai = DB::select("
                SELECT s.nama_siswa, n.nilai
                FROM siswa s, nilai_kuis n
                WHERE s.id = n.siswa_id
            ");

            $mapel = Mapel::all();
            $kelas = Kelas::all();
            $guru = Guru::all();
            $pertanyaan = Pertanyaan::where('kuis_id', $id)->get();
            return view('kuis.guru.edit', compact(['pertanyaan', 'kuis', 'nilai', 'mapel', 'kelas', 'guru']));
        }else{
            $kuis = DB::select("
                SELECT m.nama_mapel, k.nama_kelas, g.nama_guru, j.*, ku.judul_kuis, ku.id
                FROM mapel m, kelas k, guru g, kuis ku, jadwal j
                WHERE ku.id = $id AND ku.mapel_id = m.id AND ku.kelas_id = k.id AND ku.guru_id = g.id
                GROUP BY ku.id
            ");
            foreach($kuis as $kuis){
                $kuis;
            }

            $pertanyaan = Pertanyaan::where('kuis_id', $kuis->id)->count();
            return view('kuis.siswa.open', compact(['kuis', 'pertanyaan']));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $kuis = Kuis::find($id);
        $pertanyaan = Pertanyaan::where('kuis_id', $id)->get();
        $siswa_id = Siswa::where('nomor_induk', Auth::user()->nomor_induk)->value('id');
        $nilai = Nilai::where([
            ['kuis_id', $id],
            ['siswa_id', $siswa_id]
        ])->first();
        return view('kuis.siswa.hasil', compact(['kuis', 'pertanyaan', 'nilai']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $jadwal = Jadwal::where([
            ['kelas_id', $request->kelas_id],
            ['mapel_id', $request->kelas_id],
            ['guru_id', $request->guru_id]
        ])->first();

        if(empty($jadwal)){
            return back()->with('failed', 'Data Gagal di Ubah! Guru Dengan Jadwal tersebut tidak ada!');
        }else{
            // Tambah Kuis

            Kuis::where('id', $id)->update([
                'mapel_id'      => $request->mapel_id,
                'kelas_id'      => $request->kelas_id,
                'jadwal_id'     => $jadwal->id,
                'guru_id'       => $request->guru_id,
                'judul_kuis'    => $request->judul_kuis,
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ]);

            return back()->with('success', 'Data Berhasil di Ubah!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Nilai::where('kuis_id', $id)->delete();
        Jawaban::where('kuis_id',$id)->delete();
        Pertanyaan::where('kuis_id', $id)->delete();
        Kuis::destroy($id);

        return back()->with('success', 'Data Berhasil di Hapus!');
    }
}
