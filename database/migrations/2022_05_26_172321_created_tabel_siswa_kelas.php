<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatedTabelSiswaKelas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tabel_siswa_kelas', function (Blueprint $table) {
            $table->increments('id_siswa_kelas');
            $table->unsignedBigInteger('nisn')->index();
            $table->foreign('nisn')->references('nisn')->on('tabel_siswa');
            $table->string('kode_kelas')->index();
            $table->foreign('kode_kelas')->references('kode_kelas')->on('tabel_kelas');
            $table->unsignedBigInteger('id_tahun_ajaran')->index();
            $table->foreign('id_tahun_ajaran')->references('id_tahun_ajaran')->on('tabel_tahun_ajaran');
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
        //
    }
}
