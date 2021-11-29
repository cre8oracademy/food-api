<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductIngridentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_ingridents', function (Blueprint $table) {
            $table->id();
            $table->json('ingredients')->nullable();
            $table->unsignedBigInteger('for_product');
            $table->foreign('for_product')->references('product_category_item_id')->on('product_category_item')->onDelete('cascade');
            $table->integer('created_by');
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
        Schema::dropIfExists('product_ingridents');
    }
}
