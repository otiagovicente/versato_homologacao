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
        Schema::create('OrdersProducts', function (Blueprint $table) {
            $table->increments('id');
            $table->double('cost', 8,2);
            $table->double('price', 8,2);
            $table->double('discount',8,2);
            $table->integer('representative_id')->nullable();
            $table->integer('representative_comision')->nullable();
            $table->integer('representative_discount')->nullable();
            $table->integer('grid_id')->unsigned();
            $table->integer('delivery_id')->unsigned();

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
        Schema::dropIfExists('OrdersProducts');
    }
}
