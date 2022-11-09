<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreatePegawaisAndGurusTabel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pegawais_and_gurus_tabel', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('nik')->index();
            $table->foreign('nik')->references('user_code')->on('users');
            $table->string('nama');
            $table->integer('jenis_kelamin');
            $table->date('tanggal_lahir');
            $table->string('jabatan');
            $table->string('status');
            $table->unsignedBigInteger('kode_kelas')->index()->nullable();
            $table->string('lulusan');
            $table->string('foto')->nullable();
            $table->timestamps();
        });

        DB::table('pegawais_and_gurus_tabel')->insert([
            [
                'nik' => 12345678,
                'nama' => 'Sarjana Kertas',
                'jenis_kelamin' => 1,
                'tanggal_lahir' => '1998-08-21',
                'jabatan' => 1,
                'status' => 1,
                'lulusan' => 'S1 PGSD',
                'created_at' => date('Y-m-d H:s:i'),
            ],
            [
                'nik' => 23456789,
                'nama' => 'Guru 1',
                'jenis_kelamin' => 2,
                'tanggal_lahir' => '1998-08-21',
                'jabatan' => 2,
                'status' => 2,
                'lulusan' => 'S1 PGSD',
                'created_at' => date('Y-m-d H:s:i'),
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
        Schema::dropIfExists('pegawais_and_gurus_tabel');
    }
}
