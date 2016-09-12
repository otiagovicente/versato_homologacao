<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('macroregions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code');
            $table->string('description');
            $table->string('geo');
            $table->integer('brand_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('regions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code');
            $table->string('description');
            $table->string('geo');
            $table->integer('brand_id')->unsigned();
            $table->integer('masterregion_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('customers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code');
            $table->string('cuit');
            $table->string('name');
            $table->string('address');
            $table->string('geo');
            $table->integer('brand_id')->unsigned();
            $table->integer('region_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('contacts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('lastname');
            $table->string('phone1');
            $table->string('phone2');
            $table->string('phone3');
            $table->string('email1');
            $table->string('email2');
            $table->string('email3');
            $table->string('address');
            $table->string('geo');
            $table->integer('customer_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('representatives', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique();
            $table->string('email');
            $table->string('phone1');
            $table->string('phone2');
            $table->string('phone3');
            $table->integer('region_id')->unsigned();
            $table->integer('customer_id')->unsigned();
            $table->integer('brand_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
        });




    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::drop('contacts');
        Schema::drop('customers');
        Schema::drop('representatives');
        Schema::drop('regions');
        Schema::drop('macroregions');
    }
}
