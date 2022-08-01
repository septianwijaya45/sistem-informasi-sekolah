<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kuis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mapel_id')->constrained('mapel');
            $table->foreignId('kelas_id')->constrained('kelas');
            $table->foreignId('jadwal_id')->constrained('jadwal');
            $table->foreignId('guru_id')->constrained('guru');
            $table->text('judul_kuis');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kuis');
    }
};
