<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRepresentativesBrandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('brand_representative', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('brand_id')->unsigned();
            $table->integer('representative_id')->unsigned();
            $table->double('comission', 8, 2)->unsigned();
            $table->timestamps();

            $table->foreign('brand_id')->references('id')->on('brands');
            $table->foreign('representative_id')->references('id')->on('representatives');
        });


        Schema::create('region_representative', function( Blueprint $table){
            $table->increments('id');
            $table->integer('region_id')->unsigned();
            $table->integer('representative_id')->unsigned();
            $table->timestamps();

            $table->foreign('representative_id')->references('id')->on('representatives');
            $table->foreign('region_id')->references('id')->on('regions');

        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('brand_representative', function($table){
            $table->dropForeign('brand_representative_brand_id_foreign');
            $table->dropForeign('brand_representative_representative_id_foreign');
        });

        Schema::table('region_representative', function($table){
            $table->dropForeign('region_representative_region_id_foreign');
            $table->dropForeign('region_representative_representative_id_foreign');
        });



        Schema::drop('brand_representative');
        Schema::drop('region_representative');
    }




}
