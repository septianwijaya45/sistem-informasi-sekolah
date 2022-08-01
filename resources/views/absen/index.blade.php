@extends('layouts.layout')

@section('page', 'Absensi')

@section('specific-css')

@endsection

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
        @if ($jadwal)
        <div class="mb-3 row">
          <div class="col">
            <h3>Pelajaran {{ $jadwal->mapel->nama_mapel }}</h3>
          </div>
          <div class="col text-right">
            @if ($user->role == 'Siswa')
            @if ($jadwal->absensi->count() == 0)
            <form action="{{ route('absen.store') }}" method="post">
              @csrf
              <input type="text" name="jadwal_id" value="{{ $jadwal->id }}" class="d-none">
              @if ($jam_mulai < $jadwal->jam_mulai)
                <button type="submit" class="btn btn-primary" name="status" value="Hadir">Hadir</button>
                @else
                <button type="submit" class="btn btn-warning" name="status" value="Terlambat">Terlambat</button>
                @endif
                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#form-modal-izin">Izin</button>
            </form>
            @else
            <span class="bg-primary p-2">Sudah Absen</span>
            @endif
            @else
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#form-modal-materi">Upload Materi</button>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#form-modal-tugas">Upload Tugas</button>
            @endif
          </div>
        </div>
        <table id="list-table-materi" class="table table-bordered table-hover mb-3">
          <thead>
            <tr>
              <th>Nama Materi</th>
              @if ($user->role == 'Guru' || $jadwal->absensi->count() != 0)
              <th style="width: 15rem;">File</th>
              @endif
              @if ($user->role == 'Guru')
              <th style="width: 15rem;">Aksi</th>
              @endif
            </tr>
          </thead>
          <tbody>
            @foreach ($materi as $data)
            <tr>
              <td class="align-middle">{{ $data->nama_materi }}</td>
              @if ($user->role == 'Guru' || $jadwal->absensi->count() != 0)
              <td class="align-middle"><a href="{{ route('materi.show', $data->id) }}" class="btn btn-primary">Download</a></td>
              @endif
              @if ($user->role == 'Guru')
              <td class="align-middle">
                <form action="{{ route('materi.destroy', $data->id) }}" method="post">
                  @csrf
                  @method("delete")
                  <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
              </td>
              @endif
            </tr>
            @endforeach
          </tbody>
        </table>
        <table id="list-table-tugas" class="table table-bordered table-hover mb-3">
          <thead>
            <tr>
              <th>Nama Tugas</th>
              <th style="width: 15rem;">Deadline</th>
              @if ($user->role == 'Guru' || $jadwal->absensi->count() != 0)
              <th style="width: 15rem;">File</th>
              @endif
              @if ($user->role == 'Guru')
              <th style="width: 15rem;">Aksi</th>
              @endif
            </tr>
          </thead>
          <tbody>
            @foreach ($tugas as $data)
            <tr>
              <td class="align-middle">{{ $data->nama_tugas }}</td>
              <td class="align-middle">{{ $data->tanggal_deadline . ' ' . $data->jam_deadline }}</td>
              @if ($user->role == 'Guru' || $jadwal->absensi->count() != 0)
              <td class="align-middle"><a href="{{ route('tugas.show', $data->id) }}" class="btn btn-primary">Download</a></td>
              @endif
              @if ($user->role == 'Guru')
              <td class="align-middle">
                <form action="{{ route('tugas.destroy', $data->id) }}" method="post">
                  @csrf
                  @method("delete")
                  <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
              </td>
              @endif
            </tr>
            @endforeach
          </tbody>
        </table>
        @if ($user->role == 'Guru')
        <table id="list-table-absensi" class="table table-bordered table-hover">
          <thead>
            <tr>
              <th>Nama Siswa</th>
              <th style="width: 15rem;">Tanggal</th>
              <th style="width: 15rem;">Status</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
        @endif
        @else
        <div class="text-center">
          <h3>Tidak Ada Pelajaran Yang Sedang Berlangsung!</h3>
        </div>
        @endif
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
  <!-- /.col -->
</div>
<!-- /.row -->

<!-- Modal -->
<div class="modal fade" id="form-modal-materi" tabindex="-1" aria-labelledby="form-modal-label" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="form-modal-label">Upload Materi</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('materi.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
          <div class="form-group">
            <label for="nama_materi">Nama Materi</label>
            <input type="text" name="nama_materi" class="form-control">
          </div>
          <div class="form-group">
            <label for="file_materi">File Materi</label>
            <input type="file" name="file_materi" class="form-control">
            <small class="form-text text-muted">Document / PDF / PPT / Excel / Gambar / Video</small>
            <small class="form-text text-muted">Ukuran harus di bawah 100 MB</small>
          </div>
          <div class="form-group" hidden>
            <input type="text" class="form-control" name="kelas_id" value="{{ $jadwal ? $jadwal->kelas_id : '' }}">
          </div>
          <div class="form-group" hidden>
            <input type="text" class="form-control" name="mapel_id" value="{{ $jadwal ? $jadwal->mapel_id : '' }}">
          </div>
          <div class="form-group" hidden>
            <input type="text" class="form-control" name="guru_id" value="{{ $jadwal ? $jadwal->guru_id : '' }}">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Upload</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="form-modal-tugas" tabindex="-1" aria-labelledby="form-modal-label" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="form-modal-label">Upload Materi</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('tugas.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
          <div class="form-group">
            <label for="nama_tugas">Nama Tugas</label>
            <input type="text" name="nama_tugas" class="form-control">
          </div>
          <div class="form-group">
            <label for="file_tugas">File Materi</label>
            <input type="file" name="file_tugas" class="form-control">
            <small class="form-text text-muted">Document / PDF</small>
            <small class="form-text text-muted">Ukuran harus di bawah 10 MB</small>
          </div>
          <div class="form-group">
            <label for="tanggal_deadline">Tanggal Deadline</label>
            <input type="date" name="tanggal_deadline" class="form-control">
          </div>
          <div class="form-group">
            <label for="jam_deadline">Jam Deadline</label>
            <input type="time" name="jam_deadline" class="form-control">
          </div>
          <div class="form-group" hidden>
            <input type="text" class="form-control" name="kelas_id" value="{{ $jadwal ? $jadwal->kelas_id : '' }}">
          </div>
          <div class="form-group" hidden>
            <input type="text" class="form-control" name="mapel_id" value="{{ $jadwal ? $jadwal->mapel_id : '' }}">
          </div>
          <div class="form-group" hidden>
            <input type="text" class="form-control" name="guru_id" value="{{ $jadwal ? $jadwal->guru_id : '' }}">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Upload</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="form-modal-izin" tabindex="-1" aria-labelledby="form-modal-label" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="form-modal-label">Izin</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('absen.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
          <div class="form-group">
            <label for="status">Keterangan</label>
            <select name="status" class="form-control" id="status">
              <option value="Izin">Izin</option>
              <option value="Sakit">Sakit</option>
            </select>
          </div>
          <div class="form-group">
            <label for="file">File</label>
            <input type="file" name="file" class="form-control">
            <small class="form-text text-muted">Document / PDF. Ukuran harus di bawah 1 MB</small>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Kirim</button>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection

@section('specific-script')

<script>
  $(function() {
    $.validator.addMethod('filesize', function(value, element, param) {
      return this.optional(element) || (element.files[0].size <= param * 1000000)
    }, 'Maksimal ukuran file {0} MB!')

    $('#form-modal-materi form').validate({
      rules: {
        nama_materi: {
          required: true,
        },
        file_materi: {
          required: true,
          extension: 'doc?x|pdf|ppt?x|xls?x|jpe?g|png|mp4',
          filesize: 100,
        },
      },
      messages: {
        nama_materi: {
          required: "Nama materi harus di isi!",
        },
        file_materi: {
          required: "Isi file terlebih dahulu!",
          extension: 'File harus berbentuk document / pdf / ppt / excel / jpeg / png / mp4'
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

    $('#form-modal-tugas form').validate({
      rules: {
        nama_tugas: {
          required: true,
        },
        file_tugas: {
          required: true,
          extension: 'doc?x|pdf',
          filesize: 100,
        },
        tanggal_deadline: {
          required: true,
        },
        jam_deadline: {
          required: true,
        },
      },
      messages: {
        nama_tugas: {
          required: "Nama tugas harus di isi!",
        },
        file_tugas: {
          required: "Isi file terlebih dahulu!",
          extension: 'File harus berbentuk document / pdf'
        },
        tanggal_deadline: {
          required: "Tanggal deadline harus di isi!",
        },
        jam_deadline: {
          required: "Jam deadline harus di isi!",
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

    $('#form-modal-izin form').validate({
      rules: {
        file: {
          required: true,
          extension: 'doc?x|pdf',
          filesize: 1,
        },
      },
      messages: {
        file: {
          required: "Isi file terlebih dahulu!",
          extension: 'File harus berbentuk document / pdf'
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
</script>

@if ($user->role == 'Guru' && $jadwal)
<script>
  const siswa = (<?php echo $siswa ?>)
  const absensi = (<?php echo $jadwal->absensi ?>)

  const list_absensi = $('#list-table-absensi tbody').html(null)

  siswa.map(data_siswa => {
    const data_absensi = absensi.find(data_absensi => data_absensi.siswa_id == data_siswa.id)
    const status = data_absensi ? data_absensi.status : '{{ $jam_selesai < $jadwal->jam_selesai ? "Belom Hadir" : "Tidak Hadir" }}'

    let bg_status = ''

    if (status == 'Hadir') {
      bg_status = 'success'
    } else if (status == 'Terlambat') {
      bg_status = 'primary'
    } else if (status == 'Izin' || status == 'Sakit') {
      bg_status = 'warning'
    } else {
      bg_status = 'bg-danger'
    }

    list_absensi.append(`
      <tr class='${bg_status}'>
        <td class="align-middle">${data_siswa.nama_siswa}</td>
        <td class="align-middle">${data_absensi ? data_absensi.tanggal : ''}</td>
        <td class="align-middle">
          <div class='btn btn-${bg_status}' style='width: 7rem;'>${status}</div>
          ${bg_status == 'warning' ? `<a href="absen/${data_absensi.id}" class="btn btn-primary">Download</a>` : ''}
        </td>
      </tr>
    `)
  })
</script>
@endif

@endsection