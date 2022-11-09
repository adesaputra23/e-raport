<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreatedTabelTahunAjaran extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tabel_tahun_ajaran', function (Blueprint $table) {
            $table->bigIncrements('id_tahun_ajaran');
            $table->string('tahun_ajaran');
            $table->string('ket_tahun_ajaran');
            $table->integer('status_aktif');
            $table->timestamps();
        });

        DB::table('tabel_tahun_ajaran')->insert([
            [
                'tahun_ajaran' => '2021/2022',
                'ket_tahun_ajaran' => 'Tahun Ajaran 2021/2022',
                'status_aktif' => 1,
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
        //
    }
}
