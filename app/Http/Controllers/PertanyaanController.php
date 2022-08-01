<?php

namespace App\Http\Controllers;

use App\Models\Pertanyaan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PertanyaanController extends Controller
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
        Pertanyaan::insert([
            'kuis_id'       => $request->kuis_id,
            'pertanyaan'    => $request->pertanyaan,
            'opsi1'         => $request->opsi1,
            'opsi2'         => $request->opsi2,
            'opsi3'         => $request->opsi3,
            'opsi4'         => $request->opsi4,
            'opsi5'         => $request->opsi5,
            'jawaban'       => $request->jawaban,
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now()
        ]);

        return back()->with('success', 'Data Berhasil di Tambah!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        Pertanyaan::where('id', $id)->update([
            'kuis_id'       => $request->kuis_id,
            'pertanyaan'    => $request->pertanyaan,
            'opsi1'         => $request->opsi1,
            'opsi2'         => $request->opsi2,
            'opsi3'         => $request->opsi3,
            'opsi4'         => $request->opsi4,
            'opsi5'         => $request->opsi5,
            'jawaban'       => $request->jawaban,
            'updated_at'    => Carbon::now()
        ]);

        return back()->with('success', 'Data Berhasil di Edit!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Pertanyaan::destroy($id);

        return back()->with('success', 'Data Berhasil di Hapus!');
    }
}
