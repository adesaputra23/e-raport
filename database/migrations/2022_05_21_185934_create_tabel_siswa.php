<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateTabelSiswa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('tabel_siswa', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('nisn')->index();
            $table->unsignedBigInteger('nis');
            $table->foreign('nisn')->references('user_code')->on('users');
            $table->string('nama');
            $table->integer('jenis_kelamin');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->integer('agama');
            $table->string('alamat')->nullable();
            $table->string('status_anak')->nullable();
            $table->string('foto')->nullable();
            $table->string('kontak');
            $table->string('negara');
            $table->string('provinsi');
            $table->string('kota');
            $table->string('kode_pos')->nullable();
            $table->string('no_tlp_rumah')->nullable();
            $table->timestamps();
        });

        DB::table('tabel_siswa')->insert([
            [
                'nisn' => 211111,
                'nis' => 2324,
                'nama' => 'Siswa 01',
                'jenis_kelamin' => 1,
                'tempat_lahir' => 'Bondowoso',
                'tanggal_lahir' => '2015-08-21',
                'agama' => 0,
                'alamat' => 'Bonodwoso, Ardisaeng No 2',
                'status_anak' => 'Anak Ke 3',
                'kontak' => '08123242342',
                'negara' => 'Indonesia',
                'provinsi' => 'Jawa Timur',
                'kota' => 'Bondowoso',
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
        Schema::dropIfExists('tabel_siswa');
    }
}
