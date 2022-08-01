<?php

namespace App\Http\Controllers;

use App\Models\PengumpulanTugas;
use App\Models\Siswa;
use App\Models\Tugas;
use Dflydev\DotAccessData\Data;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PengumpulanTugasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
            'tugas_id' => ['required'],
            'siswa_id' => ['required'],
            'file_tugas' => ['required'],
        ]);

        if ($request->file('file_tugas')) {
            $siswa = Siswa::find($validatedData['siswa_id']);
            $validatedData['nama_file_tugas'] = $siswa->nama_siswa . '.' . $request->file('file_tugas')->getClientOriginalExtension();
            $validatedData['file_tugas'] = $request->file('file_tugas')->store('file-pengumpulan-tugas');
        }

        PengumpulanTugas::create($validatedData);

        return back()->with('success', 'Pengumpulan Tugas Berhasil!');
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
        $siswa = Siswa::where('kelas_id', $tugas->kelas_id)->get();
        $pengumpulan_tugas = PengumpulanTugas::where('tugas_id', $tugas->id)->get();

        return view('tugas.detail', [
            'tugas' => $tugas,
            'siswa' => $siswa,
            'pengumpulan_tugas' => $pengumpulan_tugas
        ]);
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
        $validatedData = $request->validate([
            'nilai' => ['required'],
        ]);

        $data = PengumpulanTugas::find($id);
        $data->update($validatedData);

        return back()->with('success', 'Ubah Nilai Berhasil!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function download($id)
    {
        $tugas = PengumpulanTugas::find($id);

        return Storage::download($tugas->file_tugas, $tugas->nama_file_tugas);
    }
}
