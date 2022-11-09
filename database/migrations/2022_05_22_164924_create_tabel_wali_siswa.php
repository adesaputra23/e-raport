<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateTabelWaliSiswa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tabel_wali_siswa', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('nisn')->index();
            $table->foreign('nisn')->references('nisn')->on('tabel_siswa');

            // Data Ayah
            $table->integer('nik_ayah')->unique()->nullable();
            $table->string('nama_ayah')->nullable();
            $table->integer('pekerjaan_ayah')->nullable();
            $table->string('telpon_ayah')->nullable();
            $table->string('email_ayah')->unique()->nullable();
            $table->integer('pendidikan_ayah')->nullable();
            $table->string('no_hp_ayah')->nullable();
            
            //Data Ibu
            $table->integer('nik_ibu')->unique()->nullable();
            $table->string('nama_ibu')->nullable();
            $table->integer('pekerjaan_ibu')->nullable();
            $table->string('telpon_ibu')->nullable();
            $table->string('email_ibu')->unique()->nullable();
            $table->integer('pendidikan_ibu')->nullable();
            $table->string('no_hp_ibu')->nullable();

            // Data Wali
            $table->integer('nik_wali')->unique()->nullable();
            $table->string('nama_wali')->nullable();
            $table->integer('pekerjaan_wali')->nullable();
            $table->string('telpon_wali')->nullable();
            $table->string('email_wali')->unique()->nullable();
            $table->integer('pendidikan_wali')->nullable();
            $table->string('no_hp_wali')->nullable();

            $table->timestamps();
        });

        DB::table('tabel_wali_siswa')->insert([
            [
                'nisn' => 211111,
            ]
        ]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tabel_wali_siswa');
    }
}
