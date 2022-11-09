<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreatedTabelKelas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tabel_kelas', function (Blueprint $table) {
            $table->string('kode_kelas')->primary();
            $table->string('kelas');
            $table->string('ket_kelas');
            $table->timestamps();
        });

        DB::table('tabel_kelas')->insert([
            [
                'kode_kelas' => 'KLS01',
                'kelas' => 'I',
                'ket_kelas' => 'Kelas 1',
                'created_at' => date('Y-m-d H:s:i'),
            ],
            [
                'kode_kelas' => 'KLS02',
                'kelas' => 'II',
                'ket_kelas' => 'Kelas 2',
                'created_at' => date('Y-m-d H:s:i'),
            ],
            [
                'kode_kelas' => 'KLS03',
                'kelas' => 'III',
                'ket_kelas' => 'Kelas 3',
                'created_at' => date('Y-m-d H:s:i'),
            ],
            [
                'kode_kelas' => 'KLS04',
                'kelas' => 'IV',
                'ket_kelas' => 'Kelas 4',
                'created_at' => date('Y-m-d H:s:i'),
            ],
            [
                'kode_kelas' => 'KLS05',
                'kelas' => 'V',
                'ket_kelas' => 'Kelas 5',
                'created_at' => date('Y-m-d H:s:i'),
            ],
            [
                'kode_kelas' => 'KLS06',
                'kelas' => 'VI',
                'ket_kelas' => 'Kelas 6',
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
