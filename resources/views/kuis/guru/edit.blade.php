@extends('layouts.layout')

@section('specific-css')


@endsection

@section('page', 'Detail Kuis & Pertanyaan')

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
    <div class="row">
      <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-primary">
                <h4>Detail Kuis</h4>
            </div>
            <form action="{{route('kuis.update', $kuis->id)}}" method="POST" enctype="multipart/form-data">
              @csrf
              @method('put')
                <div class="card-body">
                  <div class="row">
                      <div class="col-md-6">
                          <div class="form-group">
                              <label for="">Nama Kelas</label>
                              <select name="kelas_id" class="form-control" id="kelas_id">
                                <option value="">Pilih Kelas</option>
                                @foreach ($kelas as $data)
                                <option value="{{ $data->id }}" @if($kuis->kelas_id == $data->id) selected @endif>{{ $data->nama_kelas }}</option>
                                @endforeach
                              </select>
                          </div>
                          <div class="form-group">
                              <label for="">Nama Mapel</label>
                              <select name="mapel_id" class="form-control" id="mapel_id">
                                <option value="">Pilih Mapel</option>
                                @foreach ($mapel as $data)
                                <option value="{{ $data->id }}" @if($kuis->mapel_id == $data->id) selected @endif>{{ $data->nama_mapel }}</option>
                                @endforeach
                              </select>
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div class="form-group">
                              <label for="">Nama Guru</label>
                              <select name="guru_id" class="form-control" id="guru_id">
                                <option value="">Pilih Guru</option>
                                @foreach ($guru as $data)
                                <option value="{{ $data->id }}"@if($kuis->guru_id == $data->id) selected @endif>{{ $data->nama_guru }}</option>
                                @endforeach
                              </select>
                          </div>
                          <div class="form-group">
                              <label for="">Judul Kuis</label>
                              <textarea name="judul_kuis" id="judul_kuis" class="form-control" cols="5" rows="5">{{$kuis->judul_kuis}}</textarea>
                          </div>
                      </div>
                  </div>
              </div>
              <div class="card-footer">
                <button type="submit" class="btn btn-success float-right">Simpan</button>
              </div>
            </form>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card">
          <div class="card-header bg-success">
            <h4>Nilai Siswa</h4>
          </div>
          <div class="card-body">
          <table id="list-table" class="table table-bordered table-hover">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama</th>
              <th>Nilai</th>
            </tr>
          </thead>
          <tbody>
            <?php
              $no = 1;
            ?>
            @foreach ($nilai as $data)
            <tr>
              <td class="align-middle">{{ $no++ }}</td>
              <td class="align-middle">{{ $data->nama_siswa }}</td>
              <td class="align-middle">{{ $data->nilai }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
          </div>
        </div>
      </div>
    </div>
    <div class="card">
        <div class="card-header bg-cyan">
            <h3>Data Pertanyaan</h3>
        </div>
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
              <th>Pertanyaan</th>
              <th>Opsi1</th>
              <th>Opsi2</th>
              <th>Opsi3</th>
              <th>Opsi4</th>
              <th>Opsi5</th>
              <th>Jawaban</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php
              $no = 1;
            ?>
            @foreach ($pertanyaan as $data)
            <tr>
              <td class="align-middle">{{ $no++ }}</td>
              <td class="align-middle">{{ $data->pertanyaan }}</td>
              <td class="align-middle">{{ $data->opsi1 ? $data->opsi1 : '-' }}</td>
              <td class="align-middle">{{ $data->opsi2 ? $data->opsi2 : '-' }}</td>
              <td class="align-middle">{{ $data->opsi3 ? $data->opsi3 : '-' }}</td>
              <td class="align-middle">{{ $data->opsi4 ? $data->opsi4 : '-' }}</td>
              <td class="align-middle">{{ $data->opsi5 ? $data->opsi5 : '-' }}</td>
              <td class="align-middle">{{ $data->jawaban }}</td>
              <td class="align-middle">
              <button type="button" class="btn btn-primary" name="edit" data-pertanyaan="{{ $data }}" onclick="show_form_modal(this)">Edit</button>
                <button type="button" class="btn btn-danger" name="hapus" data-pertanyaan="{{ $data }}" onclick="show_form_modal(this)">Hapus</button>
              </td>
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
  <div class="modal-dialog modal-lg">
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
            <label for="kuis_id">ID Kuis</label>
            <input type="text" name="kuis_id" class="form-control" id="kuis_id" value="{{$kuis->id}}" readonly>
          </div>
          <div class="form-group">
            <label for="pertanyaan">Pertanyaan</label>
            <textarea name="pertanyaan" id="pertanyaan" class="form-control" cols="5" rows="5"></textarea>
          </div>
          <div class="form-group">
            <label for="opsi1">Opsi 1</label>
            <textarea name="opsi1" id="opsi1" class="form-control" cols="5" rows="5"></textarea>
          </div>
          <div class="form-group">
            <label for="opsi2">Opsi 2</label>
            <textarea name="opsi2" id="opsi2" class="form-control" cols="5" rows="5"></textarea>
          </div>
          <div class="form-group">
            <label for="opsi3">Opsi 3</label>
            <textarea name="opsi3" id="opsi3" class="form-control" cols="5" rows="5"></textarea>
          </div>
          <div class="form-group">
            <label for="opsi4">Opsi 4</label>
            <textarea name="opsi4" id="opsi4" class="form-control" cols="5" rows="5"></textarea>
          </div>
          <div class="form-group">
            <label for="opsi5">Opsi 5</label>
            <textarea name="opsi5" id="opsi5" class="form-control" cols="5" rows="5"></textarea>
          </div>
          <div class="form-group">
            <label for="jawaban">Jawaban</label>
            <textarea name="jawaban" id="jawaban" class="form-control" cols="5" rows="5"></textarea>
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
        pertanyaan: {
          required: true,
        },
        jawaban: {
          required: true,
        },
      },
      messages: {
        pertanyaan: {
          required: "Pertanyaan Harus Diisi!",
        },
        jawaban: {
          required: "Jawaban Harus Diisi!",
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


      form_modal.find('#form-jadwal').attr('action', '{{ route("pertanyaan.store") }}')
      form_modal.find('#form-jadwal').append('@method("post")')

      form_modal.find('#pertanyaan').val(null).prop('disabled', false)
      form_modal.find('#opsi1').val(null).prop('disabled', false)
      form_modal.find('#opsi2').val(null).prop('disabled', false)
      form_modal.find('#opsi3').val(null).prop('disabled', false)
      form_modal.find('#opsi4').val(null).prop('disabled', false)
      form_modal.find('#opsi5').val(null).prop('disabled', false)
      form_modal.find('#jawaban').val(null).prop('disabled', false)

      form_modal.find('#submit-form-modal').html('Tambah')
    } else if (button.attr('name') === 'edit') {
      const data = $(event).data('pertanyaan')
      form_modal.find('#form-modal-label').html('Edit Data Pertanyaan')

      form_modal.find('#form-jadwal').attr('action', '/pertanyaan/' + data.id)
      form_modal.find('#form-jadwal').append('@method("put")')

      form_modal.find('#id').val(data.id).prop('disabled', true)
      form_modal.find('#pertanyaan').val(data.pertanyaan).prop('disabled', false)
      form_modal.find('#opsi1').val(data.opsi1).prop('disabled', false)
      form_modal.find('#opsi2').val(data.opsi2).prop('disabled', false)
      form_modal.find('#opsi3').val(data.opsi4).prop('disabled', false)
      form_modal.find('#opsi4').val(data.opsi4).prop('disabled', false)
      form_modal.find('#opsi5').val(data.opsi5).prop('disabled', false)
      form_modal.find('#jawaban').val(data.jawaban).prop('disabled', false)

      form_modal.find('#submit-form-modal').html('Simpan')
    }else if (button.attr('name') === 'hapus') {
      const data = $(event).data('pertanyaan')
      form_modal.find('#form-modal-label').html('Hapus Data Pertanyaan')

      form_modal.find('#form-jadwal').attr('action', '/pertanyaan/' + data.id)
      form_modal.find('#form-jadwal').append('@method("delete")')

      form_modal.find('#id').val(data.id).prop('disabled', true)
      form_modal.find('#pertanyaan').val(data.pertanyaan).prop('disabled', true)
      form_modal.find('#opsi1').val(data.opsi1).prop('disabled', true)
      form_modal.find('#opsi2').val(data.opsi2).prop('disabled', true)
      form_modal.find('#opsi3').val(data.opsi4).prop('disabled', true)
      form_modal.find('#opsi4').val(data.opsi4).prop('disabled', true)
      form_modal.find('#opsi5').val(data.opsi5).prop('disabled', true)
      form_modal.find('#jawaban').val(data.jawaban).prop('disabled', true)

      form_modal.find('#submit-form-modal').html('Hapus')
    }

    form_modal.modal()
  }
</script>

@endsection