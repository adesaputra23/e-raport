<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateTabelSemester extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tabel_semester', function (Blueprint $table) {
            $table->id();
            $table->string('nama_smester');
            $table->integer('status_semester');
            $table->timestamps();
        });

        DB::table('tabel_semester')->insert([
            [
                'nama_smester' => 'Ganjil',
                'status_semester' => 1,
            ],
            [
                'nama_smester' => 'Genap',
                'status_semester' => 2,
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
        Schema::dropIfExists('tabel_semester');
    }
}
