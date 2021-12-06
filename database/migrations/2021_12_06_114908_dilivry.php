<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Dilivry extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('dilivry', function (Blueprint $table) {
            $table->bigIncrements('id');
            //order_id
            $table->uuid('order_uid');
            $table->unsignedBigInteger('for_product')->nullable();
            $table->foreign('for_product')->references('product_category_item_id')->on('product_category_item')->onDelete('cascade');
            //dilivry adress
            $table->string('dilivry_adress');

            $table->unsignedBigInteger('buyer_id')->nullable();
            $table->foreign('buyer_id')->references('id')->on('users')->onDelete('cascade');
            //payment type
            $table->string('payment_method');
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
    }
}