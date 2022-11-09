<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_code')->index();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        DB::table('users')->insert([
            [
                'user_code' => 12345678,
                'email' => 'admin11@gmail.com',
                'email_verified_at' => date('Y-m-d H:i:s'),
                'password' => bcrypt('12345678'),
                'created_at' => date('Y-m-d H:s:i'),
            ],
            [
                'user_code' => 23456789,
                'email' => 'Guru1@gmail.com',
                'email_verified_at' => date('Y-m-d H:i:s'),
                'password' => bcrypt('12345678'),
                'created_at' => date('Y-m-d H:s:i'),
            ],
            [
                'user_code' => 211111,
                'email' => 'Siswa1@gmail.com',
                'email_verified_at' => date('Y-m-d H:i:s'),
                'password' => bcrypt('12345678'),
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
        Schema::dropIfExists('users');
    }
}
