<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

//        Schema::create('contacts', function (Blueprint $table) {
//            $table->increments('id');
//            $table->jsonb('vcard')->nullable();
//            $table->integer('contactable_id')->unsigned();
//            $table->string('contactable_type');
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

//        Schema::drop('contacts');
    }
}
