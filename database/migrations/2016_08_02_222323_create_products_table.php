<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        

//        Schema::create('brands', function (Blueprint $table) {
//            $table->increments('id');
//            $table->string('name');
//            $table->text('description');
//            $table->string('image');
//            $table->string('logo')->nullable();
//            $table->timestamps();
//            $table->softDeletes();
//        });
//        Schema::create('lines', function (Blueprint $table) {
//            $table->increments('id');
//            $table->integer('code')->index();
//            $table->string('description');
//            $table->integer('brand_id');
//            $table->timestamps();
//            $table->softDeletes();
//            $table->unique(array('code', 'brand_id'));
//        });
//        Schema::create('references', function (Blueprint $table) {
//            $table->increments('id');
//            $table->integer('code')->index();
//            $table->string('description');
//            $table->integer('brand_id');
//            $table->timestamps();
//            $table->softDeletes();
//            $table->unique(array('code', 'brand_id'));
//        });
//        Schema::create('materials', function (Blueprint $table) {
//            $table->increments('id');
//            $table->integer('code')->index();
//            $table->string('description');
//            $table->string('sample');
//            $table->integer('brand_id');
//            $table->timestamps();
//            $table->softDeletes();
//            $table->unique(array('code', 'brand_id'));
//        });
//        Schema::create('colors', function (Blueprint $table) {
//            $table->increments('id');
//            $table->string('code')->index();
//            $table->string('description');
//            $table->string('color');
//            $table->string('pantone')->nullable();
//            $table->integer('brand_id');
//            $table->timestamps();
//            $table->softDeletes();
//            $table->unique(array('code', 'brand_id'));
//        });
//        Schema::create('products', function (Blueprint $table) {
//            $table->increments('id');
//            $table->string('code')->index();
//            $table->string('code_beirario')->index()->nullable();
//            $table->integer('brand_id')->unsigned()->index();
//            $table->integer('line_id')->unsigned()->index();
//            $table->integer('reference_id')->nullable();
//            $table->integer('material_id')->unsigned()->index();
//            $table->integer('color_id')->unsigned()->index();
//            $table->string('photo');
//            $table->decimal('cost', 10, 2);
//            $table->decimal('price', 10, 2);
//            $table->date('launch');
//            $table->boolean('published');
//
//            $table->softDeletes();
//            $table->timestamps();
//
//            $table->unique(array('code', 'brand_id'));
//            $table->unique(array('code_beirario', 'brand_id'));
//
//            $table->foreign('brand_id')->references('id')->on('brands');
//            $table->foreign('line_id')->references('id')->on('lines');
//            $table->foreign('reference_id')->references('id')->on('references');
//            $table->foreign('material_id')->references('id')->on('materials');
//            $table->foreign('color_id')->references('id')->on('colors');
//        });
//
//        Schema::create('sizes', function (Blueprint $table) {
//            $table->increments('id');
//            $table->string('size');
//            $table->string('locale');
//            $table->integer('brand_id')->unsigned();
//            $table->timestamps();
//        });
//
//        Schema::create('grids', function (Blueprint $table) {
//            $table->increments('id');
//            $table->string('code')->index();
//            $table->string('description');
//            $table->integer('brand_id')->unsigned();
//            $table->string('locale');
//            $table->unique(array('code', 'brand_id'));
//            $table->timestamps();
//            $table->softDeletes();
//        });
//
//        Schema::create('grid_size', function (Blueprint $table) {
//            $table->integer('grid_id')->unsigned()->index();
//            $table->foreign('grid_id')->references('id')->on('grids');
//            $table->integer('size_id')->unsigned()->index();
//            $table->foreign('size_id')->references('id')->on('sizes');
//            $table->integer('amount');
//            $table->timestamps();
//        });
//
//        Schema::create('grid_product', function (Blueprint $table) {
//            $table->integer('product_id')->unsigned()->index();
//            $table->foreign('product_id')->references('id')->on('products');
//            $table->integer('grid_id')->unsigned()->index();
//            $table->foreign('grid_id')->references('id')->on('grids');
//            $table->timestamps();
//
//        });
        Schema::create('brands', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('description');
            $table->string('image');
            $table->string('logo')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('lines', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('code')->index();
            $table->string('description');
            $table->integer('brand_id');
            $table->timestamps();
            $table->softDeletes();
            $table->unique(array('code', 'brand_id'));
        });
        Schema::create('references', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('code')->index();
            $table->string('description');
            $table->integer('brand_id');
            $table->timestamps();
            $table->softDeletes();
            $table->unique(array('code', 'brand_id'));
        });
        Schema::create('materials', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('code')->index();
            $table->string('description');
            $table->string('sample');
            $table->integer('brand_id');
            $table->timestamps();
            $table->softDeletes();
            $table->unique(array('code', 'brand_id'));
        });
        Schema::create('colors', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->index();
            $table->string('description');
            $table->string('color');
            $table->string('pantone')->nullable();
            $table->integer('brand_id');
            $table->timestamps();
            $table->softDeletes();
            $table->unique(array('code', 'brand_id'));
        });
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->index();
            $table->string('code_beirario')->index()->nullable();
            $table->integer('brand_id')->unsigned()->index();
            $table->integer('line_id')->unsigned()->index();
            $table->integer('reference_id')->nullable();
            $table->integer('material_id')->unsigned()->index();
            $table->integer('color_id')->unsigned()->index();
            $table->string('photo');
            $table->decimal('cost', 10, 2);
            $table->decimal('price', 10, 2);
            $table->date('launch');
            $table->boolean('published');

            $table->softDeletes();
            $table->timestamps();

            $table->unique(array('code', 'brand_id'));
            $table->unique(array('code_beirario', 'brand_id'));

            $table->foreign('brand_id')->references('id')->on('brands');
            $table->foreign('line_id')->references('id')->on('lines');
            $table->foreign('reference_id')->references('id')->on('references');
            $table->foreign('material_id')->references('id')->on('materials');
            $table->foreign('color_id')->references('id')->on('colors');
        });
        
        Schema::create('sizes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('size');
            $table->string('locale');
            $table->integer('brand_id')->unsigned();
            $table->timestamps();
        });

        Schema::create('grids', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->index();
            $table->string('description');
            $table->integer('brand_id')->unsigned();
            $table->string('locale');
            $table->unique(array('code', 'brand_id'));
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('grid_size', function (Blueprint $table) {
            $table->integer('grid_id')->unsigned()->index();
            $table->foreign('grid_id')->references('id')->on('grids');
            $table->integer('size_id')->unsigned()->index();
            $table->foreign('size_id')->references('id')->on('sizes');
            $table->integer('amount');
            $table->timestamps();
        });

        Schema::create('grid_product', function (Blueprint $table) {
            $table->integer('product_id')->unsigned()->index();
            $table->foreign('product_id')->references('id')->on('products');
            $table->integer('grid_id')->unsigned()->index();
            $table->foreign('grid_id')->references('id')->on('grids');
            $table->timestamps();

        });
      
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
//
//        Schema::table('products', function($table){
//
//            $table->dropForeign('products_brand_id_foreign');
//            $table->dropForeign('products_line_id_foreign');
//            $table->dropForeign('products_reference_id_foreign');
//            $table->dropForeign('products_material_id_foreign');
//            $table->dropForeign('products_color_id_foreign');
//
//        });
//        Schema::table('grid_product', function($table){
//            $table->dropForeign('grid_product_grid_id_foreign');
//            $table->dropForeign('grid_product_product_id_foreign');
//        });
//
//        Schema::table('grid_size', function($table){
//            $table->dropForeign('grid_size_grid_id_foreign');
//            $table->dropForeign('grid_size_size_id_foreign');
//        });
//
//
//
//        Schema::drop('brands');
//        Schema::drop('lines');
//        Schema::drop('references');
//        Schema::drop('materials');
//        Schema::drop('colors');
//        Schema::drop('grid_product');
//        Schema::drop('grid_size');
//        Schema::drop('products');
//        Schema::drop('grids');
//        Schema::drop('sizes');

    }
}
