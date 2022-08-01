@extends('layouts.layout')

@section('page', 'Dashboard')

@section('specific-css')

@endsection

@section('content')

<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <div class="mb-3">
          <h3>Jadwal Hari Ini</h3>
        </div>
        <table id="list-table" class="table table-bordered table-hover">
          <thead>
            <tr>
              <th>{{ Auth::user()->role == 'Guru' ? 'Nama Kelas' : 'Nama Guru' }}</th>
              <th>Nama Mapel</th>
              <th>Jam</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($jadwal as $data)
            <tr>
              <td class="align-middle">{{ Auth::user()->role == 'Guru' ? $data->kelas->nama_kelas : $data->guru->nama_guru }}</td>
              <td class="align-middle">{{ $data->mapel->nama_mapel }}</td>
              <td class="align-middle">{{ $data->jam_mulai }} - {{ $data->jam_selesai }}</td>
              <td class="align-middle">
                @if ($data->jam_mulai > now()->toTimeString())
                <span class="bg-info p-2">Belum Mulai</span>
                @elseif ($data->jam_selesai < now()->toTimeString())
                  <span class="bg-success p-2">Selesai</span>
                  @else
                  <span class="bg-primary p-2">Berlangsung</span>
                  @endif
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

@endsection

@section('specific-script')

@endsection
