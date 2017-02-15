<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderproductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        Schema::create('order_product', function (Blueprint $table) {
//            $table->increments('product_id');
//            $table->double('cost', 8,2);
//            $table->double('price', 8,2);
//            $table->double('discount',8,2);
//            $table->integer('representative_id')->nullable();
//            $table->integer('representative_comission')->nullable();
//            $table->integer('representative_discount')->nullable();
//            $table->integer('grid_id')->unsigned();
//            $table->integer('delivery_id')->unsigned();
//            $table->integer('order_id')->unsigned();
//            $table->string('code')->nullable();
//            $table->string('strLine')->nullable();
//            $table->string('strMaterial')->nullable();
//            $table->string('strColor')->nullable();
//            $table->string('chk_client_discount')->nullable();
//            $table->string('chk_representative_discount')->nullable();
//            $table->string('strGrid')->nullable();
//            $table->string('total')->nullable();
//
//            $table->timestamps();
//        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
//        Schema::dropIfExists('orders_products');
    }
}
