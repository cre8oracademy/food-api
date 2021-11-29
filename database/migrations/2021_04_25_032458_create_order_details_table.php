<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->id('order_detail_id');
            $table->unsignedBigInteger('order_id');
            $table->foreign('order_id')->references('order_id')->on('order_t')->onDelete('cascade');
            $table->integer('product_category_id')->nullable();
            $table->integer('product_category_item_id')->nullable();
            $table->string('custom')->nullable();
            $table->float('item_price')->default($value= 0);
            $table->integer('item_quantity')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('m_delete')->nullable();
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
        Schema::dropIfExists('order_details');
    }
}
