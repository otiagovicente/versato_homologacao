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

            $table->integer('status_id')->nullable();
            $table->integer('customer_id')->nullable();
            $table->integer('representative_id')->nullable();
            $table->integer('representative_comision')->nullable();
            $table->integer('representative_discount')->nullable();
            
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
