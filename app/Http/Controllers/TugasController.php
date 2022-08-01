<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Siswa;
use App\Models\Tugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TugasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->role == 'Guru') {
            $guru = Guru::where('nomor_induk', $user->nomor_induk)->first();

            return view('tugas.index', [
                'user' => $user,
                'guru' => $guru,
                'tugas' => Tugas::where('guru_id', $guru->id)->orderBy('id', 'desc')->get()
            ]);
        }

        $siswa = Siswa::where('nomor_induk', $user->nomor_induk)->first();

        return view('tugas.index', [
            'user' => $user,
            'siswa' => $siswa,
            'tugas' => Tugas::where('kelas_id', $siswa->kelas_id)->orderBy('id', 'desc')->get()
        ]);
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
        $validatedData = $request->validate([
            'nama_tugas' => ['required'],
            'file_tugas' => ['required'],
            'tanggal_deadline' => ['required'],
            'jam_deadline' => ['required'],
            'kelas_id' => ['required'],
            'mapel_id' => ['required'],
            'guru_id' => ['required'],
        ]);

        $validatedData['tanggal'] = date('Y-m-d');

        if ($request->file('file_tugas')) {
            $validatedData['file_tugas'] = $request->file('file_tugas')->store('file-tugas');
            $validatedData['nama_file_tugas'] = $validatedData['tanggal'] . ' - ' . $validatedData['nama_tugas'] . '.' . $request->file('file_tugas')->getClientOriginalExtension();
        }

        Tugas::create($validatedData);

        return back()->with('success', 'Upload Tugas Berhasil!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tugas = Tugas::find($id);

        return Storage::download($tugas->file_tugas, $tugas->nama_file_tugas);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tugas = Tugas::find($id);
        Storage::delete($tugas->file_tugas);

        Tugas::destroy($id);

        return back()->with('success', 'Tugas Berhasil di Hapus!');
    }
}
