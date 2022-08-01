<?php

namespace App\Http\Controllers;

use App\Models\Jawaban;
use App\Models\Kuis;
use App\Models\Nilai;
use App\Models\Pertanyaan;
use App\Models\Siswa;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JawabController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('siswa.jawab');
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
        $pertanyaan = Pertanyaan::where('kuis_id', $request->kuis_id)->get();
        foreach($pertanyaan as $data){
            $jawaban = new Jawaban();
            $jawaban->kuis_id = $request->kuis_id;
            $jawaban->pertanyaan_id = $data->id;
            $jawaban->nomor_induk = Auth::user()->nomor_induk;
            $jawaban->jawaban   = $request->opsi[$data->id];
            if($request->opsi[$data->id] == $data->jawaban){
                $jawaban->cek_jawaban = 1;
            }else{
                $jawaban->cek_jawaban = 0;
            }
            $jawaban->created_at = Carbon::now();
            $jawaban->updated_at = Carbon::now();
            $jawaban->save();
        }

        $totPertanyaan = count($pertanyaan);
        $totBenar = Jawaban::where([
            ['kuis_id', $request->kuis_id],
            ['nomor_induk', Auth::user()->nomor_induk],
            ['cek_jawaban', 1]
        ])->count();

        $siswa_id = Siswa::where('nomor_induk', Auth::user()->nomor_induk)->value('id');

        Nilai::insert([
            'kuis_id'       => $request->kuis_id,
            'siswa_id'      => $siswa_id,
            'nilai'         => ($totBenar/$totPertanyaan) * 100,
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now()
        ]);
        return redirect()->route('kuis.index')->with('success', 'Kuis Berhasil Diselesaikan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $kuis = Kuis::find($id);
        $pertanyaan = Pertanyaan::where('kuis_id', $id)->get();
        return view('kuis.siswa.jawab', compact(['kuis', 'pertanyaan']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
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
        //
    }
}
