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
        Schema::create('pertanyaans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kuis_id')->constrained('kuis');
            $table->text('pertanyaan');
            $table->text('opsi1')->nullable();
            $table->text('opsi2')->nullable();
            $table->text('opsi3')->nullable();
            $table->text('opsi4')->nullable();
            $table->text('opsi5')->nullable();
            $table->text('jawaban');
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
        Schema::dropIfExists('pertanyaans');
    }
};
