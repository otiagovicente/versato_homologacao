<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->increments('id');
            $table->string('description');
            $table->integer('brand_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('product_tag', function (Blueprint $table){
            $table->integer('product_id')->unsigned()->index();
            $table->foreign('product_id')->references('id')->on('products');
            $table->integer('tag_id')->unsigned()->index();
            $table->foreign('tag_id')->references('id')->on('tags');

        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_tag', function($table){
            $table->dropForeign('product_tag_product_id_foreign');
            $table->dropForeign('product_tag_tag_id_foreign');
        });
        Schema::drop('product_tag');
        Schema::drop('tags');
    }
}
