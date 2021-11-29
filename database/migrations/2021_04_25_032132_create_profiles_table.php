<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('name')->nullable();
            $table->string('Description')->nullable();
            $table->set('Type_of_Business', ['Restaurant', 'Home-Based'])->nullable();
            $table->boolean('Halal')->default($value= false);
            $table->boolean('Varified')->default($value= false);
            $table->string('Phone')->nullable();
            $table->string('profile_pic')->default($value= "default.png");
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
        Schema::dropIfExists('profiles');
    }
}
