@extends('layouts.layout')

@section('specific-css')


@endsection

@section('page', 'Kuis')

@section('content')

<div class="row">
  <div class="col-12">
    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      {{ session('success') }}
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    @elseif(session('failed'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      {{ session('failed') }}
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    @endif
    <div class="card">
      <div class="card-body">
        @if (Auth::user()->role == 'Guru')
        <div class="mb-3">
          <button type="button" class="btn btn-success" name="tambah" onclick="show_form_modal(this)">
            Tambah Data
          </button>
        </div>
        @endif
        <table id="list-table" class="table table-bordered table-hover">
          <thead>
            <tr>
              <th>No</th>
              <th>Kuis</th>
              <th>Kelas</th>
              <th>Mapel</th>
              <th>Total Pertanyaan</th>
              <th>Nilaiku</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php

use App\Models\Jawaban;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Nilai;
use App\Models\Pertanyaan;

              $no = 1;
            ?>
            @foreach ($kuis as $data)
            <?php 
              $namaKelas = Kelas::where('id', $data->kelas_id)->value('nama_kelas');
              $namaMapel = Mapel::where('id', $data->mapel_id)->value('nama_mapel');
              $totPertanyaan = Pertanyaan::where('kuis_id', $data->id)->count();
              $jawaban = Jawaban::where([
                ['kuis_id', $data->id],
                ['nomor_induk', Auth()->user()->nomor_induk]
              ])->count();
              $nilai = Nilai::where([
                ['kuis_id', $data->id],
                ['siswa_id', $siswa->id]
              ])->first();
            ?>
            <tr>
                @if($totPertanyaan > 0)
                    <td class="align-middle">{{ $no++ }}</td>
                    <td class="align-middle">{{ $data->judul_kuis }}</td>
                    <td class="align-middle">{{ $namaKelas }}</td>
                    <td class="align-middle">{{ $namaMapel }}</td>
                    <td class="align-middle">{{ $totPertanyaan }}</td>
                    <td class="align-middle">{{ $nilai ? $nilai->nilai : '0' }}</td>
                    @if(empty($jawaban))
                    <td class="align-middle">
                        <a href="{{route('kuis.show', $data->id)}}">
                        <button type="button" class="btn btn-primary">Jawab</button>
                        </a>
                    </td>
                    @else
                    <td class="align-middle">
                    <a href="{{route('kuis.edit', $data->id)}}">
                        <button type="button" class="btn btn-warning">Cek Jawaban</button>
                        </a>
                    </td>
                    @endif
                @else
                @endif
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
  <!-- /.col -->
</div>
<!-- /.row -->

@endsection