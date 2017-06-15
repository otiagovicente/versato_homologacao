<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        Schema::create('users', function (Blueprint $table) {
//            $table->increments('id');
//            $table->string('name');
//            $table->string('lastname')->nullable();
//            $table->string('mobile')->nullable();
//            $table->string('occupation')->nullable();
//            $table->text('about')->nullable();
//            $table->string('facebook')->nullable();
//            $table->string('twitter')->nullable();
//            $table->string('instagram')->nullable();
//            $table->string('email')->unique();
//            $table->string('password');
//            $table->integer('role_id');//1 - Admin, 2 - Editor, 3 - Representative
//            $table->string('photo')->nullable();
//            $table->boolean('blocked')->nullable();
//
//            $table->rememberToken();
//            $table->timestamps();
//            $table->softDeletes();
//        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
//        Schema::drop('users');
    }
}
