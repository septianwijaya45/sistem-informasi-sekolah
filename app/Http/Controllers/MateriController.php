<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Mapel;
use App\Models\Materi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MateriController extends Controller
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
            'nama_materi' => ['required'],
            'file_materi' => ['required'],
            'kelas_id' => ['required'],
            'mapel_id' => ['required'],
            'guru_id' => ['required'],
        ]);

        $validatedData['tanggal'] = date('Y-m-d');

        if ($request->file('file_materi')) {
            $validatedData['file_materi'] = $request->file('file_materi')->store('file-materi');
            $validatedData['nama_file_materi'] = $validatedData['tanggal'] . ' - ' . $validatedData['nama_materi'] . '.' . $request->file('file_materi')->getClientOriginalExtension();
        }

        Materi::create($validatedData);

        return back()->with('success', 'Upload Materi Berhasil!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $materi = Materi::find($id);

        return Storage::download($materi->file_materi, $materi->nama_file_materi);
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
        $materi = Materi::find($id);
        Storage::delete($materi->file_materi);

        Materi::destroy($id);

        return back()->with('success', 'Materi Berhasil di Hapus!');
    }
}
