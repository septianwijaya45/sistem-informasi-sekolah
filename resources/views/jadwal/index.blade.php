@extends('layouts.layout')

@section('specific-css')


@endsection

@section('page', 'Jadwal')

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
    @endif
    <div class="card">
      <div class="card-body">
        @if ($user->role == 'Guru')
        <div class="mb-3">
          <button type="button" class="btn btn-success" name="tambah" onclick="show_form_modal(this)">
            Tambah Data
          </button>
        </div>
        @endif
        <table id="list-table" class="table table-bordered table-hover">
          <thead>
            <tr>
              <th>Hari</th>
              <th>Kelas</th>
              <th>Mapel</th>
              <th>Guru</th>
              <th>Jam</th>
              @if ($user->role == 'Guru')
              <th>Aksi</th>
              @endif
            </tr>
          </thead>
          <tbody>
            @foreach ($jadwal as $data)
            <tr>
              <td class="align-middle">{{ $hari[$data->hari - 1] }}</td>
              <td class="align-middle">{{ $data->kelas->nama_kelas }}</td>
              <td class="align-middle">{{ $data->mapel->nama_mapel }}</td>
              <td class="align-middle">{{ $data->guru->nama_guru }}</td>
              <td class="align-middle">{{ $data->jam_mulai }} - {{ $data->jam_selesai }}</td>
              @if ($user->role == 'Guru')
              <td class="align-middle">
                <button type="button" class="btn btn-primary" name="edit" data-jadwal="{{ $data }}" onclick="show_form_modal(this)">Edit</button>
                <button type="button" class="btn btn-danger" name="hapus" data-jadwal="{{ $data }}" onclick="show_form_modal(this)">Hapus</button>
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
      <form id="form-jadwal" action="{{ route('jadwal.store') }}" method="post">
        @csrf
        <div class="modal-body">
          <div class="form-group" hidden>
            <label for="id">ID</label>
            <input type="text" name="id" class="form-control" id="id">
          </div>
          <div class="form-group">
            <label for="hari">Hari</label>
            <select name="hari" class="form-control" id="hari">
              <option value="">Pilih Hari</option>
              <option value="1">Senin</option>
              <option value="2">Selasa</option>
              <option value="3">Rabu</option>
              <option value="4">Kamis</option>
              <option value="5">Jumat</option>
              <option value="6">Sabtu</option>
            </select>
          </div>
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
          </div>
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
            <label for="jam_mulai">Jam Mulai</label>
            <input type="time" name="jam_mulai" class="form-control" id="jam_mulai" placeholder="00:00">
          </div>
          <div class="form-group">
            <label for="jam_selesai">Jam Selesai</label>
            <input type="time" name="jam_selesai" class="form-control" id="jam_selesai" placeholder="00:00">
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
    $.validator.addMethod(
      "check_jam",
      function(value, element) {
        let jadwal = (<?php echo $jadwal; ?>)
        let id = $('#form-modal #id').val()
        let hari = $('#form-modal #hari').val()
        value = value + ':00'
        jadwal = jadwal.find(data => data.id != id && data.hari == hari && data.jam_mulai < value && data.jam_selesai > value)

        return jadwal ? false : true
      },
      "Jam bentrok dengan jadwal lain!"
    );

    $('#form-modal #form-jadwal').validate({
      rules: {
        hari: {
          required: true,
        },
        kelas_id: {
          required: true,
        },
        mapel_id: {
          required: true,
        },
        guru_id: {
          required: true,
        },
        jam_mulai: {
          required: true,
          check_jam: true,
        },
        jam_selesai: {
          required: true,
          check_jam: true,
        },
      },
      messages: {
        hari: {
          required: "Pilih hari dengan benar!",
        },
        kelas_id: {
          required: "Pilih kelas dengan benar!",
        },
        mapel_id: {
          required: "Pilih mapel dengan benar!",
        },
        guru_id: {
          required: "Pilih guru dengan benar!",
        },
        jam_mulai: {
          required: "Jam mulai harus di isi!",
        },
        jam_selesai: {
          required: "Jam selesai harus di isi!",
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
      form_modal.find('#form-modal-label').html('Tambah Data Jadwal')
      let user = (<?php echo $user; ?>)
      let guru = (<?php echo $guru; ?>)
      let kelas = (<?php echo $kelas; ?>)

      guru = guru.find(guru => guru.nomor_induk == user.nomor_induk)
      kelas = kelas[0]

      form_modal.find('#form-jadwal').attr('action', '{{ route("jadwal.store") }}')
      form_modal.find('#form-jadwal').append('@method("post")')

      form_modal.find('#id').val(null).prop('disabled', false)
      form_modal.find('#hari').val(1).prop('disabled', false)
      form_modal.find('#kelas_id').val(kelas.id || null).prop('disabled', false)
      form_modal.find('#mapel_id').val(null).prop('disabled', false)
      form_modal.find('#guru_id').val(guru.id || null).prop('disabled', false)
      form_modal.find('#jam_mulai').val(null).prop('disabled', false)
      form_modal.find('#jam_selesai').val(null).prop('disabled', false)

      form_modal.find('#submit-form-modal').html('Tambah')
    } else if (button.attr('name') === 'edit') {
      const data = $(event).data('jadwal')
      form_modal.find('#form-modal-label').html('Edit Data Jadwal')

      form_modal.find('#form-jadwal').attr('action', '/jadwal/' + data.id)
      form_modal.find('#form-jadwal').append('@method("put")')

      form_modal.find('#id').val(data.id).prop('disabled', false)
      form_modal.find('#hari').val(data.hari).prop('disabled', false)
      form_modal.find('#kelas_id').val(data.kelas_id).prop('disabled', false)
      form_modal.find('#mapel_id').val(data.mapel_id).prop('disabled', false)
      form_modal.find('#guru_id').val(data.guru_id).prop('disabled', false)
      form_modal.find('#jam_mulai').val(data.jam_mulai).prop('disabled', false)
      form_modal.find('#jam_selesai').val(data.jam_selesai).prop('disabled', false)

      form_modal.find('#submit-form-modal').html('Simpan')
    } else if (button.attr('name') === 'hapus') {
      const data = $(event).data('jadwal')
      form_modal.find('#form-modal-label').html('Hapus Data Jadwal')

      form_modal.find('#form-jadwal').attr('action', '/jadwal/' + data.id)
      form_modal.find('#form-jadwal').append('@method("delete")')

      form_modal.find('#id').val(data.id).prop('disabled', true)
      form_modal.find('#hari').val(data.hari).prop('disabled', true)
      form_modal.find('#kelas_id').val(data.kelas_id).prop('disabled', true)
      form_modal.find('#mapel_id').val(data.mapel_id).prop('disabled', true)
      form_modal.find('#guru_id').val(data.guru_id).prop('disabled', true)
      form_modal.find('#jam_mulai').val(data.jam_mulai).prop('disabled', true)
      form_modal.find('#jam_selesai').val(data.jam_selesai).prop('disabled', true)

      form_modal.find('#submit-form-modal').html('Hapus')
    }

    form_modal.modal()
  }
</script>

@endsection