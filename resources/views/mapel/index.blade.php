@extends('layouts.layout')

@section('specific-css')


@endsection

@section('page', 'Mapel')

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
              <th>Nama Mapel</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($mapel as $data)
            <tr>
              <td class="align-middle">{{ $loop->iteration }}</td>
              <td class="align-middle">{{ $data->nama_mapel }}</td>
              <td class="align-middle">
                <button type="button" class="btn btn-primary" name="edit" data-mapel="{{ $data }}" onclick="show_form_modal(this)">Edit</button>
                <button type="button" class="btn btn-danger" name="hapus" data-mapel="{{ $data }}" onclick="show_form_modal(this)">Hapus</button>
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
      <form id="form-mapel" action="{{ route('mapel.store') }}" method="post">
        @csrf
        <div class="modal-body">
          <div class="form-group">
            <label for="nama_mapel">Nama Mapel</label>
            <input type="text" name="nama_mapel" class="form-control" id="nama_mapel" placeholder="Isi Nama Mapel">
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
    $('#form-modal #form-mapel').validate({
      rules: {
        nama_mapel: {
          required: true,
        },
      },
      messages: {
        nama_guru: {
          required: "Nama Mapel harus di isi!",
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
      form_modal.find('#form-modal-label').html('Tambah Data Mapel')

      form_modal.find('#form-mapel').attr('action', '{{ route("mapel.store") }}')
      form_modal.find('#form-mapel').append('@method("post")')

      form_modal.find('#nama_mapel').val(null).prop('disabled', false)

      form_modal.find('#submit-form-modal').html('Tambah')
    } else if (button.attr('name') === 'edit') {
      const data = $(event).data('mapel')
      form_modal.find('#form-modal-label').html('Edit Data Mapel')

      form_modal.find('#form-mapel').attr('action', '/mapel/' + data.id)
      form_modal.find('#form-mapel').append('@method("put")')

      form_modal.find('#nama_mapel').val(data.nama_mapel).prop('disabled', false)

      form_modal.find('#submit-form-modal').html('Simpan')
    } else if (button.attr('name') === 'hapus') {
      const data = $(event).data('mapel')
      form_modal.find('#form-modal-label').html('Hapus Data Mapel')

      form_modal.find('#form-mapel').attr('action', '/mapel/' + data.id)
      form_modal.find('#form-mapel').append('@method("delete")')

      form_modal.find('#nama_mapel').val(data.nama_mapel).prop('disabled', true)

      form_modal.find('#submit-form-modal').html('Hapus')
    }

    form_modal.modal()
  }
</script>

@endsection