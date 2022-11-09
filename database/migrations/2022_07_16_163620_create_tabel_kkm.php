<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateTabelKkm extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tabel_kkm', function (Blueprint $table) {
            $table->id();
            $table->integer('nilai_kkm');
            $table->string('desc_kkm');
            $table->timestamps();
        });

        DB::table('tabel_kkm')->insert([
            'nilai_kkm' => 65,
            'desc_kkm' => 'Nilai KKM keseluruhan Mata Pelajaran',
            'created_at' => date('Y-m-d H:s:i'),
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tabel_kkm');
    }
}
