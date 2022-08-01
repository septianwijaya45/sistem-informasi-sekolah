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
                    <h3>Lihat Tugas</h3>
                </div>
                <table id="list-table" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Nama Siswa</th>
                            <th>Pengumpulan</th>
                            <th>Nilai</th>
                            <th style="width: 15rem;">File</th>
                        </tr>
                    </thead>
                    <tbody>
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
                <h5 class="modal-title" id="form-modal-label">Ubah Nilai</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('pengumpulan_tugas.store') }}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nilai">Nilai</label>
                        <input type="number" name="nilai" class="form-control" id="nilai">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="submit-form-modal">Ubah</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('specific-script')

<script>
    const siswa = (<?php echo $siswa ?>)
    const pengumpulan_tugas = (<?php echo $pengumpulan_tugas ?>)

    const list_tugas = $('#list-table tbody').html(null)

    siswa.map(data_siswa => {
        const data_tugas = pengumpulan_tugas.find(data_tugas => data_tugas.siswa_id == data_siswa.id)

        list_tugas.append(`
            <tr class='${data_tugas ? '' : 'bg-danger'}'>
                <td class="align-middle">${data_siswa.nama_siswa}</td>
                <td class="align-middle">${data_tugas ? data_tugas.tanggal + ' ' + data_tugas.jam : ''}</td>
                <td class="align-middle">${data_tugas ? data_tugas.nilai : 0}</td>
                <td class="align-middle">${data_tugas ? `
                    <a href="${data_tugas.id}/download" class="btn btn-success">Download</a>
                    <button class="btn btn-primary" onclick="show_form_modal(this, '${data_tugas.id}')">Ubah Nilai</button>
                ` : ''}</td>
            </tr>
        `)
    })

    const show_form_modal = (event, id) => {
        const form_modal = $('#form-modal')
        const data_tugas = pengumpulan_tugas.find(data_tugas => data_tugas.id == id)

        form_modal.find('form').attr('action', '/pengumpulan_tugas/' + id)
        form_modal.find('form').append('@method("put")')

        form_modal.find('#nilai').val(data_tugas.nilai)

        form_modal.modal()
    }
</script>

@endsection