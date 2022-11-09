<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateRolesTabel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles_tabel', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_code')->index();
            $table->foreign('user_code')->references('user_code')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('user_role');
            $table->timestamps();
        });

        DB::table('roles_tabel')->insert(
            [
                [
                    'user_code' => 12345678,
                    'user_role' => 1,
                    'created_at' => date('Y-m-d H:s:i'),
                ],
                [
                    'user_code' => 12345678,
                    'user_role' => 2,
                    'created_at' => date('Y-m-d H:s:i'),
                ],
                [
                    'user_code' => 23456789,
                    'user_role' => 2,
                    'created_at' => date('Y-m-d H:s:i'),
                ],
                [
                    'user_code' => 211111,
                    'user_role' => 4,
                    'created_at' => date('Y-m-d H:s:i'),
                ],
            ]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles_tabel');
    }
}
