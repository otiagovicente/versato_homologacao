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
            $table->string('description')->nullable();
            $table->longText('geo');
            $table->integer('brand_id')->nullable();
            $table->timestamps();
            $table->softDeletes();

        });

        Schema::create('regions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code');
            $table->string('description');
            $table->longText('geo');
            $table->integer('brand_id')->nullable();
            $table->integer('macroregion_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('macroregion_id')->references('id')->on('macroregions');

        });

        Schema::create('customers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code');
            $table->string('cuit')->nullable();
            $table->string('company')->nullable();
            $table->string('name');
            $table->string('logo')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('zip')->nullable();
            $table->string('email')->nullable();
            $table->string('phone1')->nullable();
            $table->string('phone2')->nullable();
            $table->string('phone3')->nullable();
            $table->string('geo')->nullable();
            $table->integer('region_id')->unsigned();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('region_id')->references('id')->on('regions');
        });

        Schema::create('shops', function (Blueprint $table){
            $table->increments('id');
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('logo')->nullable();
            $table->string('address');
            $table->string('geo');
            $table->integer('customer_id')->unsigned();

            $table->foreign('customer_id')->references('id')->on('customers');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('representatives', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique();
            $table->integer('user_id')->unsigned()->unique();
            $table->longText('token')->nullable();
            $table->longText('qrcode')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('representatives', function($table){
            $table->dropForeign('representatives_user_id_foreign');
        });
        Schema::table('customers', function($table){
            $table->dropForeign('customers_region_id_foreign');
        });
        Schema::table('shops', function($table){
            $table->dropForeign('shops_customer_id_foreign');
        });
        Schema::table('regions', function($table){
            $table->dropForeign('regions_macroregion_id_foreign');
        });

        Schema::drop('shops');
        Schema::drop('customers');
        Schema::drop('representatives');
        Schema::drop('regions');
        Schema::drop('macroregions');
    }
}
