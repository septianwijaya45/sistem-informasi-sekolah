<?php
use App\Models\Jawaban;
use Illuminate\Support\Facades\Auth;
?>
@extends('layouts.layout')

@section('specific-css')


@endsection

@section('page', 'Hasil Kuisku ('.$kuis->judul_kuis.')')

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
            <h4>Jawaban Kuis</h4>
            <h5 class="text-white float-right">Nilai : {{$nilai->nilai}}</h5>
        </div>
        <form action="{{ route('jawab.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        @foreach($pertanyaan as $data)
                        <?php

                            $jawaban = Jawaban::where([
                                    ['kuis_id', $kuis->id],
                                    ['pertanyaan_id', $data->id],
                                    ['nomor_induk', Auth::user()->nomor_induk]
                                ])->first();
                        ?>
                            <div class="card">
                                <div class="card-header">{{$data->pertanyaan}}</div>
                                <div class="card-body">
                                    <input type="hidden" name="kuis_id" value="{{$kuis->id}}">
                                    <input type="hidden" name="pertanyaan_id" value="{{$data->id}}">
                                    @if(!empty($data->opsi1))
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="opsi[{{ $data->id }}]" id="opsi-{{ $data->id }}" value="{{ $data->opsi1 }}" @if($jawaban->jawaban == $data->opsi1) checked @endif disabled>
                                        <label class="form-check-label" for="option-{{ $data->id }}">
                                            {{ $data->opsi1 }}
                                        </label>
                                    </div>
                                    @endif
                                    @if(!empty($data->opsi2))
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="opsi[{{ $data->id }}]" id="opsi-{{ $data->id }}" value="{{ $data->opsi2 }}" @if($jawaban->jawaban == $data->opsi2) checked @endif disabled>
                                        <label class="form-check-label" for="option-{{ $data->id }}">
                                            {{ $data->opsi2 }}
                                        </label>
                                    </div>
                                    @endif
                                    @if(!empty($data->opsi3))
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="opsi[{{ $data->id }}]" id="opsi-{{ $data->id }}" value="{{ $data->opsi3 }}" @if($jawaban->jawaban == $data->opsi3) checked @endif disabled>
                                        <label class="form-check-label" for="option-{{ $data->id }}">
                                            {{ $data->opsi3 }}
                                        </label>
                                    </div>
                                    @endif
                                    @if(!empty($data->opsi4))
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="opsi[{{ $data->id }}]" id="opsi-{{ $data->id }}" value="{{ $data->opsi4 }}" @if($jawaban->jawaban == $data->opsi4) checked @endif disabled>
                                        <label class="form-check-label" for="option-{{ $data->id }}">
                                            {{ $data->opsi4 }}
                                        </label>
                                    </div>
                                    @endif
                                    @if(!empty($data->opsi5))
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="opsi[{{ $data->id }}]" id="opsi-{{ $data->id }}" value="{{ $data->opsi5 }}" @if($jawaban->jawaban == $data->opsi5) checked @endif disabled>
                                        <label class="form-check-label" for="option-{{ $data->id }}">
                                            {{ $data->opsi5 }}
                                        </label>
                                    </div>
                                    @endif
                                </div>
                                <div class="card-footer">
                                    <h6 class="text-success">Jawaban Benar : {{$data->jawaban}}</h6>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- /.card -->
  </div>
  <!-- /.col -->
</div>
<!-- /.row -->


@endsection
