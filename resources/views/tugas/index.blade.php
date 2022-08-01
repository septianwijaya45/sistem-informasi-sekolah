@extends('layouts.layout')

@section('page', 'Tugas')

@section('specific-css')

@endsection

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="mb-3">
                    <h3>Daftar Tugas</h3>
                </div>
                <table id="list-table" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            @if ($user->role == 'Guru')
                            <th>Kelas</th>
                            @endif
                            <th>Mapel</th>
                            <th>Nama Tugas</th>
                            <th>Tanggal</th>
                            <th>Deadline</th>
                            @if ($user->role == 'Siswa')
                            <th>Nilai</th>
                            <th>Status</th>
                            @else
                            <th>Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tugas as $data)
                        <tr>
                            @if ($user->role == 'Guru')
                            <td class="align-middle">{{ $data->kelas->nama_kelas }}</td>
                            @endif
                            <td class="align-middle">{{ $data->mapel->nama_mapel }}</td>
                            <td class="align-middle">{{ $data->nama_tugas }}</td>
                            <td class="align-middle">{{ $data->tanggal }}</td>
                            <td class="align-middle">{{ $data->tanggal_deadline }} - {{ $data->jam_deadline }}</td>
                            @if ($user->role == 'Siswa')
                            @if ($data->pengumpulan->count() == 0)
                            <td class="align-middle">0</td>
                            @else
                            <td class="align-middle">{{ $data->pengumpulan->first()->nilai }}</td>
                            @endif
                            <td class="align-middle">
                                @if ($data->pengumpulan->count() == 0)
                                @if (($data->tanggal_deadline . ' ' . $data->jam_deadline) > now())
                                <span class="btn btn-warning">Belom Mengumpulkan</span>
                                <button type="button" class="btn btn-primary" data-tugas="{{ $data }}" onclick="show_form_modal(this)">Upload</button>
                                @else
                                <span class="bg-danger p-2">Tidak Mengumpulkan</span>
                                @endif
                                @else
                                <span class="bg-primary p-2">Sudah Mengumpulkan</span>
                                @endif
                            </td>
                            @else
                            <td class="align-middle">
                                <a href="{{ route('pengumpulan_tugas.show', $data->id) }}" class="btn btn-primary">Lihat Tugas</a>
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

@if ($user->role == 'Siswa')
<!-- Modal -->
<div class="modal fade" id="form-modal" tabindex="-1" aria-labelledby="form-modal-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="form-modal-label">Pengumpulan Tugas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-mapel" action="{{ route('pengumpulan_tugas.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group" hidden>
                        <label for="tugas_id">Tugas ID</label>
                        <input type="text" name="tugas_id" class="form-control" id="tugas_id">
                    </div>
                    <div class="form-group" hidden>
                        <label for="siswa_id">Siswa ID</label>
                        <input type="text" name="siswa_id" class="form-control" id="siswa_id" value="{{ $siswa->id }}">
                    </div>
                    <div class="form-group">
                        <label for="file_tugas">File</label>
                        <input type="file" name="file_tugas" class="form-control" id="file_tugas">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="submit-form-modal">Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

@endsection

@section('specific-script')

@if ($user->role == 'Siswa')
<script>
    const show_form_modal = (event) => {
        const form_modal = $('#form-modal')
        const button = $(event)
        const data = button.data('tugas')

        form_modal.find('#tugas_id').val(data.id)

        form_modal.modal()
    }
</script>
@endif

@endsection