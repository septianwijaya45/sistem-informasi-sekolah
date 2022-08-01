<?php

namespace Database\Seeders;

use App\Models\Guru;
use App\Models\Jadwal;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   *
   * @return void
   */
  public function run()
  {
    // \App\Models\User::factory(10)->create();

    // \App\Models\User::factory()->create([
    //     'name' => 'Test User',
    //     'email' => 'test@example.com',
    // ]);

    User::create([
      'email' => 'admin@gmail.com',
      'role' => 'Guru',
      'password' => Hash::make('admin'),
    ]);

    // Guru::create([
    //   'nama_guru' => 'Guru 1',
    //   'jenis_kelamin' => 'L',
    //   'tempat_lahir' => 'Kediri',
    //   'tanggal_lahir' => '2017-04-19',
    //   'nomor_induk' => '1',
    //   'nomor_telepon' => '1',
    //   'email' => 'guru1@gmail.com',
    //   'password' => Hash::make('123'),
    // ]);

    // Kelas::create([
    //   'nama_kelas' => 'Kelas 4',
    //   'guru_id' => '1',
    // ]);

    // Mapel::create([
    //   'nama_mapel' => 'Matematika',
    // ]);

    // Jadwal::create([
    //   'hari' => 1,
    //   'kelas_id' => 1,
    //   'mapel_id' => 1,
    //   'guru_id' => 1,
    //   'jam_mulai' => '07:00:00',
    //   'jam_selesai' => '09:00:00',
    // ]);

    // Siswa::create([
    //   'nama_siswa' => 'Siswa 1',
    //   'jenis_kelamin' => 'L',
    //   'tempat_lahir' => 'Kediri',
    //   'tanggal_lahir' => '2017-04-19',
    //   'nomor_induk' => '111',
    //   'nomor_telepon' => '111',
    //   'email' => 'siswa1@gmail.com',
    //   'password' => Hash::make('123'),
    //   'kelas_id' => '1',
    // ]);

    // User::create([
    //   'email' => 'guru1@gmail.com',
    //   'role' => 'Guru',
    //   'nomor_induk' => '1',
    //   'password' => Hash::make('123'),
    // ]);

    // User::create([
    //   'email' => 'siswa1@gmail.com',
    //   'role' => 'Siswa',
    //   'nomor_induk' => '111',
    //   'password' => Hash::make('123'),
    // ]);
  }
}
