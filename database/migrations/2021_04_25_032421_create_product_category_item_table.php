<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductCategoryItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_category_item', function (Blueprint $table) {
            $table->id('product_category_item_id');
            $table->string('product_category_item_name')->default($value= "Product Name");
            $table->string('product_category_item_description')->default($value= "Product Discription");
            $table->double('product_category_item_price')->default($value= 0);
            $table->boolean('custom_order')->default($value= false);
            $table->boolean('active')->default($value= false);
            $table->boolean('list_ingredients')->default($value= false);
            $table->json('is_allergic')->nullable();
            $table->uuid('product_uid')->nullable();
            $table->boolean('m_delete')->nullable();
            $table->unsignedBigInteger('product_category_id');
            $table->foreign('product_category_id')->references('product_category_id')->on('product_category')->onDelete('cascade');
            $table->integer('product_image_id')->nullable();            
            $table->unsignedBigInteger('added_by');
            $table->foreign('added_by')->references('id')->on('profiles')->onDelete('cascade');
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
        Schema::dropIfExists('product_category_item');
    }
}
