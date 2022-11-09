<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateTabelMataPelajaran extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tabel_mata_pelajaran', function (Blueprint $table) {
            $table->id();
            $table->string('kode_mt')->index();
            $table->string('nama_mt');
            $table->text('desc_mt');
            $table->unsignedBigInteger('nik');
            $table->string('kode_kurikulum')->index();
            $table->string('kode_kelas')->index();
            $table->foreign('nik')->references('nik')->on('pegawais_and_gurus_tabel');
            $table->foreign('kode_kurikulum')->references('kode_kurikulum')->on('tabel_kurikulum');
            $table->foreign('kode_kelas')->references('kode_kelas')->on('tabel_kelas');
            $table->timestamps();
        });

        DB::table('tabel_mata_pelajaran')->insert([
            [
                'kode_mt' => 'MT001',
                'nama_mt' => 'Bahasa Indonesia',
                'desc_mt' => 'Mata Pelajaran B.Indonesia',
                'nik'     => 23456789,
                'kode_kurikulum' => 'KR13',
                'kode_kelas'    => 'KLS01',
                'created_at' => date('Y-m-d H:s:i'),
            ],
            [
                'kode_mt' => 'MT002',
                'nama_mt' => 'Matematika',
                'desc_mt' => 'Mata Pelajaran Matematika',
                'nik'     => 23456789,
                'kode_kurikulum' => 'KR13',
                'kode_kelas'    => 'KLS01',
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
        Schema::dropIfExists('tabel_mata_pelajaran');
    }
}
