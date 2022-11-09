<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateTabelKurikulum extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tabel_kurikulum', function (Blueprint $table) {
            $table->string('kode_kurikulum')->primary();
            $table->string('nama_kurikulum');
            $table->string('desc_kurikulum');
            $table->integer('status_kurikulum');
            $table->timestamps();
        });

        DB::table('tabel_kurikulum')->insert([
            [
                'kode_kurikulum' => 'KR13',
                'nama_kurikulum' => 'Kurikulum K13',
                'desc_kurikulum' => 'Kurikulum K13',
                'created_at' => date('Y-m-d H:s:i'),
                'status_kurikulum' => 1,
            ],
            [
                'kode_kurikulum' => 'KR22',
                'nama_kurikulum' => 'Kurikulum Prototipe / 2022',
                'desc_kurikulum' => 'Kurikulum 2022/Prototipe',
                'created_at' => date('Y-m-d H:s:i'),
                'status_kurikulum' => 2,
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
        Schema::dropIfExists('tabel_kurikulum');
    }
}
