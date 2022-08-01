@extends('layouts.layout')

@section('specific-css')


@endsection

@section('page', 'Guru')

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
        <div class="mb-3">
          <button type="button" class="btn btn-success" name="tambah" onclick="show_form_modal(this)">
            Tambah Data
          </button>
        </div>
        <table id="list-table" class="table table-bordered table-hover">
          <thead>
            <tr>
              <th>No.</th>
              <th>Foto</th>
              <th>Nama</th>
              <th>Email</th>
              <th>Nomor Induk</th>
              <th>Telepon</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($guru as $data)
            <tr>
              <td class="align-middle">{{ $loop->iteration }}</td>
              <td class="align-middle">
                @if ($data->file_foto)
                <img src="{{ asset('storage/'. $data->file_foto) }}" alt="Foto" style="height: 100px;" />
                @else
                <img src="{{ asset($data->jenis_kelamin === 'L' ? 'img/male.jpg' : 'img/female.jpg') }}" alt="Foto" style="height: 100px;" />
                @endif
              </td>
              <td class="align-middle">{{ $data->nama_guru }}</td>
              <td class="align-middle">{{ $data->email }}</td>
              <td class="align-middle">{{ $data->nomor_induk }}</td>
              <td class="align-middle">{{ $data->nomor_telepon }}</td>
              <td class="align-middle">
                <button type="button" class="btn btn-primary" name="edit" data-guru="{{ $data }}" onclick="show_form_modal(this)">Edit</button>
                <button type="button" class="btn btn-danger" name="hapus" data-guru="{{ $data }}" onclick="show_form_modal(this)">Hapus</button>
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
      <form id="form-guru" action="{{ route('guru.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
          @if ($errors->any())
          @foreach ($errors->all() as $error)
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ $error }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          @endforeach
          @endif
          <div class="row">
            <div class="col">
              <div class="form-group d-none">
                <label for="guru_id"></label>
                <input type="text" name="guru_id" class="form-control" id="guru_id">
              </div>
              <div class="form-group">
                <label for="file_foto">Foto</label>
                <input type="file" name="file_foto" class="form-control" id="file_foto" accept="image/*">
              </div>
              <div class="form-group">
                <label for="nama_guru">Nama Guru</label>
                <input type="text" name="nama_guru" class="form-control" id="nama_guru" placeholder="Isi Nama Guru">
              </div>
              <div class="form-group">
                <label for="jenis_kelamin">Jenis Kelamin</label>
                <select name="jenis_kelamin" class="form-control" id="jenis_kelamin">
                  <option value="">Pilih Jenis Kelamin</option>
                  <option value="L">Laki - Laki</option>
                  <option value="P">Perempuan</option>
                </select>
              </div>
              <div class="form-group">
                <label for="tempat_lahir">Tempat Lahir</label>
                <input type="text" name="tempat_lahir" class="form-control" id="tempat_lahir" placeholder="Isi Tempat Lahir">
              </div>
              <div class="form-group">
                <label for="tanggal_lahir">Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir" class="form-control" id="tanggal_lahir">
              </div>
            </div>
            <div class="col">
              <div class="form-group">
                <label for="nomor_induk">Nomor Induk</label>
                <input type="text" name="nomor_induk" class="form-control" id="nomor_induk" placeholder="Isi Nomor Induk">
              </div>
              <div class="form-group">
                <label for="nomor_telepon">Nomor Telepon</label>
                <input type="text" name="nomor_telepon" class="form-control" id="nomor_telepon" placeholder="Isi Nomor Telepon">
              </div>
              <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control" id="email" placeholder="Isi Email">
              </div>
              <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" class="form-control" id="password" placeholder="Isi Password">
              </div>
            </div>
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
    $('#form-modal #form-guru').validate({
      rules: {
        nama_guru: {
          required: true,
        },
        jenis_kelamin: {
          required: true,
        },
        tempat_lahir: {
          required: true,
        },
        tanggal_lahir: {
          required: true,
        },
        nomor_induk: {
          required: true,
        },
        nomor_telepon: {
          required: true,
        },
        email: {
          required: true,
        },
      },
      messages: {
        nama_guru: {
          required: "Nama harus di isi!",
        },
        jenis_kelamin: {
          required: "Pilih jenis kelamin dengan benar!",
        },
        tempat_lahir: {
          required: "Tempat lahir harus di isi!",
        },
        tanggal_lahir: {
          required: "Tanggal lahir harus di isi!",
        },
        nomor_induk: {
          required: "Nomor induk harus di isi!",
        },
        nomor_telepon: {
          required: "Nomor telepon harus di isi!",
        },
        email: {
          required: "Email harus di isi!",
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
      form_modal.find('#form-modal-label').html('Tambah Data Guru')

      form_modal.find('#form-guru').attr('action', '{{ route("guru.store") }}')
      form_modal.find('#form-guru').append('@method("post")')

      form_modal.find('#guru_id').val(null)
      form_modal.find('#file_foto').prop('disabled', false)
      form_modal.find('#nama_guru').val(null).prop('disabled', false)
      form_modal.find('#jenis_kelamin').val(null).prop('disabled', false)
      form_modal.find('#tempat_lahir').val(null).prop('disabled', false)
      form_modal.find('#tanggal_lahir').val(null).prop('disabled', false)
      form_modal.find('#nomor_induk').val(null).prop('disabled', false)
      form_modal.find('#nomor_telepon').val(null).prop('disabled', false)
      form_modal.find('#email').val(null).prop('disabled', false)
      form_modal.find('#password').val(null).prop('disabled', false)

      form_modal.find('#submit-form-modal').html('Tambah')
    } else if (button.attr('name') === 'edit') {
      const data = $(event).data('guru')
      form_modal.find('#form-modal-label').html('Edit Data Guru')

      form_modal.find('#form-guru').attr('action', '/guru/' + data.id)
      form_modal.find('#form-guru').append('@method("put")')

      form_modal.find('#guru_id').val(data.id)
      form_modal.find('#file_foto').prop('disabled', false)
      form_modal.find('#nama_guru').val(data.nama_guru).prop('disabled', false)
      form_modal.find('#jenis_kelamin').val(data.jenis_kelamin).prop('disabled', false)
      form_modal.find('#tempat_lahir').val(data.tempat_lahir).prop('disabled', false)
      form_modal.find('#tanggal_lahir').val(data.tanggal_lahir).prop('disabled', false)
      form_modal.find('#nomor_induk').val(data.nomor_induk).prop('disabled', false)
      form_modal.find('#nomor_telepon').val(data.nomor_telepon).prop('disabled', false)
      form_modal.find('#email').val(data.email).prop('disabled', false)
      form_modal.find('#password').val(null).prop('disabled', false)

      form_modal.find('#submit-form-modal').html('Simpan')
    } else if (button.attr('name') === 'hapus') {
      const data = $(event).data('guru')
      form_modal.find('#form-modal-label').html('Hapus Data Guru')

      form_modal.find('#form-guru').attr('action', '/guru/' + data.id)
      form_modal.find('#form-guru').append('@method("delete")')

      form_modal.find('#guru_id').val(data.id)
      form_modal.find('#file_foto').prop('disabled', true)
      form_modal.find('#nama_guru').val(data.nama_guru).prop('disabled', true)
      form_modal.find('#jenis_kelamin').val(data.jenis_kelamin).prop('disabled', true)
      form_modal.find('#tempat_lahir').val(data.tempat_lahir).prop('disabled', true)
      form_modal.find('#tanggal_lahir').val(data.tanggal_lahir).prop('disabled', true)
      form_modal.find('#nomor_induk').val(data.nomor_induk).prop('disabled', true)
      form_modal.find('#nomor_telepon').val(data.nomor_telepon).prop('disabled', true)
      form_modal.find('#email').val(data.email).prop('disabled', true)
      form_modal.find('#password').val(null).prop('disabled', true)

      form_modal.find('#submit-form-modal').html('Hapus')
    }

    form_modal.modal()
  }
</script>

@if ($errors->any())
<script>
  const form_modal = $('#form-modal')
  form_modal.modal()

  form_modal.find('#form-modal-label').html('Edit Data Guru')

  form_modal.find('#form-guru').attr('action', '/guru/' + '{{ old("guru_id") }}')
  form_modal.find('#form-guru').append('@method("put")')

  form_modal.find('#guru_id').val('{{ old("guru_id") }}')
  form_modal.find('#nama_guru').val('{{ old("nama_guru") }}').prop('disabled', false)
  form_modal.find('#jenis_kelamin').val('{{ old("jenis_kelamin") }}').prop('disabled', false)
  form_modal.find('#tempat_lahir').val('{{ old("tempat_lahir") }}').prop('disabled', false)
  form_modal.find('#tanggal_lahir').val('{{ old("tanggal_lahir") }}').prop('disabled', false)
  form_modal.find('#nomor_induk').val('{{ old("nomor_induk") }}').prop('disabled', false)
  form_modal.find('#nomor_telepon').val('{{ old("nomor_telepon") }}').prop('disabled', false)

  form_modal.find('#submit-form-modal').html('Simpan')
</script>
@endif

@endsection