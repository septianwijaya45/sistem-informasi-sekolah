@extends('layouts.layout')

@section('specific-css')


@endsection

@section('page', 'User')

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
              <th>Email</th>
              <th>Role</th>
              <th>Nomor Induk</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($user as $data)
            <tr>
              <td class="align-middle">{{ $loop->iteration }}</td>
              <td class="align-middle">{{ $data->email }}</td>
              <td class="align-middle">{{ $data->role }}</td>
              <td class="align-middle">{{ $data->nomor_induk }}</td>
              <td class="align-middle">
                <button type="button" class="btn btn-primary" name="edit" data-user="{{ $data }}" onclick="show_form_modal(this)">Edit</button>
                <button type="button" class="btn btn-danger" name="hapus" data-user="{{ $data }}" onclick="show_form_modal(this)">Hapus</button>
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
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="form-modal-label">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="form-user" action="{{ route('user.store') }}" method="post">
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
          <div class="form-group d-none">
            <label for="user_id"></label>
            <input type="text" name="user_id" class="form-control" id="user_id">
          </div>
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" id="email" placeholder="Isi Email">
          </div>
          <div class="form-group">
            <label for="role">Role</label>
            <select name="role" class="form-control" id="role">
              <option value="">Pilih Role</option>
              <option value="Guru">Guru</option>
              <option value="Siswa">Siswa</option>
            </select>
          </div>
          <div class="form-group">
            <label for="nomor_induk">Nomor Induk</label>
            <input type="text" name="nomor_induk" class="form-control" id="nomor_induk" placeholder="Isi Nomor Induk">
          </div>
          <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" class="form-control" id="password" placeholder="Isi Password">
          </div>
          <div class="form-group">
            <label for="confirm_password">Confirm Password</label>
            <input type="password" name="confirm_password" class="form-control" id="confirm_password" placeholder="Isi Confirm Password">
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
    $('#form-modal #form-user').validate({
      rules: {
        email: {
          required: true,
        },
        role: {
          required: true,
        },
        nomor_induk: {
          required: true,
        },
        password: {
          required: true,
        },
        confirm_password: {
          required: true,
          equalTo: "#password",
        },
      },
      messages: {
        email: {
          required: "Email harus di isi!",
        },
        role: {
          required: "Pilih role dengan benar!",
        },
        nomor_induk: {
          required: "Nomor induk harus di isi!",
        },
        password: {
          required: "Password harus di isi!",
        },
        confirm_password: {
          required: "Confirm password harus di isi sama dengan password!",
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
      form_modal.find('#form-modal-label').html('Tambah Data User')

      form_modal.find('#form-user').attr('action', '{{ route("user.store") }}')
      form_modal.find('#form-user').append('@method("post")')

      form_modal.find('#user_id').val(null)
      form_modal.find('#email').val(null).prop('disabled', false)
      form_modal.find('#role').val(null).prop('disabled', false)
      form_modal.find('#nomor_induk').val(null).prop('disabled', false)
      form_modal.find('#password').val(null).prop('disabled', false)
      form_modal.find('#confirm_password').val(null).prop('disabled', false)

      form_modal.find('#submit-form-modal').html('Tambah')
    } else if (button.attr('name') === 'edit') {
      const data = $(event).data('user')
      form_modal.find('#form-modal-label').html('Edit Data User')

      form_modal.find('#form-user').attr('action', '/user/' + data.id)
      form_modal.find('#form-user').append('@method("put")')

      console.log(data)

      form_modal.find('#user_id').val(data.id)
      form_modal.find('#email').val(data.email).prop('disabled', false)
      form_modal.find('#role').val(data.role).prop('disabled', false)
      form_modal.find('#nomor_induk').val(data.nomor_induk).prop('disabled', false)
      form_modal.find('#password').prop('disabled', true)
      form_modal.find('#confirm_password').prop('disabled', true)

      form_modal.find('#submit-form-modal').html('Simpan')
    } else if (button.attr('name') === 'hapus') {
      const data = $(event).data('user')
      form_modal.find('#form-modal-label').html('Hapus Data User')

      form_modal.find('#form-user').attr('action', '/user/' + data.id)
      form_modal.find('#form-user').append('@method("delete")')

      form_modal.find('#user_id').val(data.id)
      form_modal.find('#email').val(data.email).prop('disabled', true)
      form_modal.find('#role').val(data.role).prop('disabled', true)
      form_modal.find('#nomor_induk').val(data.nomor_induk).prop('disabled', true)
      form_modal.find('#password').prop('disabled', true)
      form_modal.find('#confirm_password').prop('disabled', true)

      form_modal.find('#submit-form-modal').html('Hapus')
    }

    form_modal.modal()
  }
</script>

@if ($errors->any())
<script>
  const form_modal = $('#form-modal')
  form_modal.modal()


  const data = $(event).data('user')
  form_modal.find('#form-modal-label').html('Edit Data User')

  form_modal.find('#form-user').attr('action', '/user/{{ old("user_id") }}')
  form_modal.find('#form-user').append('@method("put")')

  form_modal.find('#user_id').val('{{ old("user_id") }}')
  form_modal.find('#email').val('{{ old("email") }}').prop('disabled', false)
  form_modal.find('#role').val('{{ old("role") }}').prop('disabled', false)
  form_modal.find('#nomor_induk').val('{{ old("nomor_induk") }}').prop('disabled', false)
  form_modal.find('#password').val(data.password).prop('disabled', true)
  form_modal.find('#confirm_password').val(data.password).prop('disabled', true)

  form_modal.find('#submit-form-modal').html('Simpan')
</script>
@endif

@endsection