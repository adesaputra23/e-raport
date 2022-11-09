<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateTabelKompetensiDasar extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tabel_kompetensi_dasar', function (Blueprint $table) {
            $table->string('kode_kd')->primary();
            $table->string('nama_kd');
            $table->string('kode_mt')->index();
            $table->foreign('kode_mt')->references('kode_mt')->on('tabel_mata_pelajaran');
            $table->string('desc_kd');
            $table->timestamps();
        });

        DB::table('tabel_kompetensi_dasar')->insert([
            [
                'kode_kd' => 'KD001',
                'nama_kd' => 'MT 01',
                'kode_mt' => 'MT001',
                'desc_kd' => 'Kompetensi Dasar Mata Pelajaran Bahasa Indonesia 01',
                'created_at' => date('Y-m-d H:s:i'),
            ],
            [
                'kode_kd' => 'KD002',
                'nama_kd' => 'MT 02',
                'kode_mt' => 'MT001',
                'desc_kd' => 'Kompetensi Dasar Mata Pelajaran Bahasa Indonesia 02',
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
        Schema::dropIfExists('tabel_kompetensi_dasar');
    }
}
