@extends('layouts.layout')

@section('specific-css')


@endsection

@section('page', 'Persiapan Kuis')

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
        <div class="card-header bg-primary">
            <h4>Detail Kuis</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Nama Kelas</label>
                        <input type="text" class="form-control" value="{{$kuis->nama_kelas}}" readonly>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Nama Mapel</label>
                        <input type="text" class="form-control" value="{{$kuis->nama_mapel}}" readonly>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="">Nama Guru</label>
                        <input type="text" class="form-control" value="{{$kuis->nama_guru}}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="">Judul Kuis</label>
                        <textarea name="judul_kuis" id="judul_kuis" class="form-control" cols="5" rows="5" readonly>{{$kuis->judul_kuis}}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="">Total Pertanyaan</label>
                        <input type="text" class="form-control" value="Total {{$pertanyaan}} Soal" readonly>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <a href="{{ route('jawab.show', $kuis->id) }}" class="btn btn-success float-right">Kerjakan Sekarang!</a>
        </div>
    </div>
    <!-- /.card -->
  </div>
  <!-- /.col -->
</div>
<!-- /.row -->


@endsection
