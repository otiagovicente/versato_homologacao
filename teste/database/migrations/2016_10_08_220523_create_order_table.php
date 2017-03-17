<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->double('cost', 8,2);
            $table->double('price',8,2);
            $table->double('overalldiscount',8,2);
            $table->longText('comment');

            $table->integer('status_id')->nullable();
            $table->integer('customer_id')->nullable();
            $table->integer('representative_id')->nullable();
            $table->double('representative_comision', 8,2)->nullable();
            $table->double('representative_discount', 8,2)->nullable();
            $table->integer('delivery_id')->nullable()->nullable();
            $table->double('customer_discount', 8,2)->nullable();
            $table->double('total', 8,2)->nullable();
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
        Schema::dropIfExists('Orders');
    }
}
