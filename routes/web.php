<?php

use App\Http\Controllers\AbsenController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\JawabController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\KuisController;
use App\Http\Controllers\MapelController;
use App\Http\Controllers\MateriController;
use App\Http\Controllers\PengumpulanTugasController;
use App\Http\Controllers\PertanyaanController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\TugasController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('guest')->group(function () {
  Route::get('/login', [AuthController::class, 'loginView'])->name('login');
  Route::post('/login', [AuthController::class, 'loginLogic'])->name('login.logic');
  Route::get('/register', [AuthController::class, 'registerView'])->name('register');
  Route::post('/register', [AuthController::class, 'registerLogic'])->name('register.logic');
});

Route::middleware('auth')->group(function () {
  Route::get('/', [HomeController::class, 'index'])->name('home');
  Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
  Route::post('/logout', [AuthController::class, 'logoutLogic'])->name('logout');
  Route::get('/pengumpulan_tugas/{id}/download', [PengumpulanTugasController::class, 'download'])->name('pengumpulan_tugas.download');
  Route::resources([
    'jadwal' => JadwalController::class,
    'guru' => GuruController::class,
    'kelas' => KelasController::class,
    'mapel' => MapelController::class,
    'siswa' => SiswaController::class,
    'user' => UserController::class,
    'absen' => AbsenController::class,
    'materi' => MateriController::class,
    'tugas' => TugasController::class,
    'pengumpulan_tugas' => PengumpulanTugasController::class,
    'kuis'  => KuisController::class,
    'pertanyaan'  => PertanyaanController::class,
    'jawab'  => JawabController::class
  ]);
});
