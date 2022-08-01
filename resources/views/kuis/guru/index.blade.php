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
              @if (Auth::user()->role == 'Guru')
              <th>Total Mengerjakan</th>
              <th>Aksi</th>
              @endif
            </tr>
          </thead>
          <tbody>
            <?php

use App\Models\Jawaban;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Pertanyaan;

              $no = 1;
            ?>
            @foreach ($kuis as $data)
            <?php 
              $namaKelas = Kelas::where('id', $data->kelas_id)->value('nama_kelas');
              $namaMapel = Mapel::where('id', $data->mapel_id)->value('nama_mapel');
              $totPertanyaan = Pertanyaan::where('kuis_id', $data->id)->count();
              $totJawaban = Count(Jawaban::where('kuis_id', $data->id)->groupBy('nomor_induk')->get());
            ?>
            <tr>
              <td class="align-middle">{{ $no++ }}</td>
              <td class="align-middle">{{ $data->judul_kuis }}</td>
              <td class="align-middle">{{ $namaKelas }}</td>
              <td class="align-middle">{{ $namaMapel }}</td>
              <td class="align-middle">{{ $totPertanyaan }}</td>
              @if (Auth::user()->role == 'Guru')
              <td class="align-middle">{{ $totJawaban }}</td>
              <td class="align-middle">
                <a href="{{route('kuis.show', $data->id)}}">
                  <button type="button" class="btn btn-primary">Lihat</button>
                </a>
                <button type="button" class="btn btn-danger" name="hapus" data-kuis="{{ $data }}" onclick="show_form_modal(this)">Hapus</button>
              </td>
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

<!-- Modal -->
<div class="modal fade" id="form-modal" tabindex="-1" aria-labelledby="form-modal-label" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="form-modal-label">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="form-jadwal" action="{{ route('kuis.store') }}" method="post">
        @csrf
        <div class="modal-body">
          <div class="form-group">
            <label for="kelas_id">Kelas</label>
            <select name="kelas_id" class="form-control" id="kelas_id">
              <option value="">Pilih Kelas</option>
              @foreach ($kelas as $data)
              <option value="{{ $data->id }}">{{ $data->nama_kelas }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label for="mapel_id">Mapel</label>
            <select name="mapel_id" class="form-control" id="mapel_id">
              <option value="">Pilih Mapel</option>
              @foreach ($mapel as $data)
              <option value="{{ $data->id }}">{{ $data->nama_mapel }}</option>
              @endforeach
            </select>
          <div class="form-group">
            <label for="guru_id">Guru</label>
            <select name="guru_id" class="form-control" id="guru_id">
              <option value="">Pilih Guru</option>
              @foreach ($guru as $data)
              <option value="{{ $data->id }}">{{ $data->nama_guru }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label for="judul_kuis">Judul Kuis</label>
            <textarea name="judul_kuis" id="judul_kuis" class="form-control" cols="10" rows="10"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" id="submit-form-modal">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection

@section('specific-script')

<script>
  $(function() {

    $('#form-modal #form-jadwal').validate({
      rules: {
        kelas_id: {
          required: true,
        },
        mapel_id: {
          required: true,
        },
        guru_id: {
          required: true,
        },
        judul_kuis: {
          required: true,
        },
      },
      messages: {
        kelas_id: {
          required: "Pilih kelas dengan benar!",
        },
        mapel_id: {
          required: "Pilih mapel dengan benar!",
        },
        guru_id: {
          required: "Pilih guru dengan benar!",
        },
        judul_kuis: {
          required: "Kuis Harus Diisi!",
        },
      },
      errorElement: 'span',
      errorPlacement: function(error, element) {
        error.addClass('invalid-feedback');
        element.closest('.form-group').append(error);
      },
      highlight: function(element, errorClass, validClass) {
        $(element).addClass('is-invalid');
      },
      unhighlight: function(element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
      },
    })

    $("#list-table").DataTable({
      "ordering": false,
      "responsive": true,
      "lengthChange": true,
      "autoWidth": true,
    })
    // }).container().appendTo('#list-table_wrapper .col-md-6:eq(0)')
  })

  const show_form_modal = (event) => {
    const form_modal = $('#form-modal')
    const button = $(event)

    if (button.attr('name') === 'tambah') {
      form_modal.find('#form-modal-label').html('Tambah Kuis')


      form_modal.find('#form-jadwal').attr('action', '{{ route("kuis.store") }}')
      form_modal.find('#form-jadwal').append('@method("post")')

      form_modal.find('#kelas_id').val(null).prop('disabled', false)
      form_modal.find('#mapel_id').val(null).prop('disabled', false)
      form_modal.find('#guru_id').val(null).prop('disabled', false)
      form_modal.find('#judul_kuis').val(null).prop('disabled', false)

      form_modal.find('#submit-form-modal').html('Tambah')
    } else if (button.attr('name') === 'hapus') {
      const data = $(event).data('kuis')
      form_modal.find('#form-modal-label').html('Hapus Data Jadwal')

      form_modal.find('#form-jadwal').attr('action', '/kuis/' + data.id)
      form_modal.find('#form-jadwal').append('@method("delete")')

      form_modal.find('#id').val(data.id).prop('disabled', true)
      form_modal.find('#kelas_id').val(data.kelas_id).prop('disabled', true)
      form_modal.find('#mapel_id').val(data.mapel_id).prop('disabled', true)
      form_modal.find('#guru_id').val(data.guru_id).prop('disabled', true)
      form_modal.find('#judul_kuis').val(data.judul_kuis).prop('disabled', true)

      form_modal.find('#submit-form-modal').html('Hapus')
    }

    form_modal.modal()
  }
</script>

@endsection