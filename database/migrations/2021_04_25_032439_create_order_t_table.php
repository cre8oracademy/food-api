<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderTTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_t', function (Blueprint $table) {
            $table->id('order_id');
            $table->uuid('order_uid')->nullable();
            $table->unsignedBigInteger('buyer_id');
            $table->foreign('buyer_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('total_products')->nullable();
            $table->integer('total_amount')->nullable();
            $table->boolean('active')->default($value= false);
            $table->boolean('canceled')->default($value= false);
            $table->boolean('completed')->default($value= false);
            $table->integer('created_by')->nullable();
            $table->time('deleted_at')->nullable();            
            $table->boolean('m_delete')->nullable();
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
        Schema::dropIfExists('order_t');
    }
}
