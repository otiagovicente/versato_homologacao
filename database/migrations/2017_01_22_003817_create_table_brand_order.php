<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableBrandOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brand_order', function (Blueprint $table) {
            $table->double('cost', 16,2);
            $table->double('price', 16,2);
            $table->double('discount', 16,2);
            $table->double('overalldiscount', 16,2);
            $table->integer('order_id')->unsigned();
            $table->integer('brand_id')->unsigned();
            $table->integer('amount')->unsigned();
            $table->integer('representative_commission')->nullable();
            $table->integer('representative_commission_discount')->nullable();
            $table->integer('representative_commission_percentage')->nullable();
            $table->integer('representative_discount')->nullable();
            $table->integer('customer_discount')->nullable();
            $table->string('total')->nullable();

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
	    Schema::dropIfExists('brand_order');
    }
}
