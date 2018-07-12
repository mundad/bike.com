<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRentalBikeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rental_bikes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('rental_id');
            $table->integer('bike_type_id');
            $table->tinyInteger('count');
            $table->softDeletes();
            $table->Integer('delete_user_id')->default(0);
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
        Schema::dropIfExists('rental_bike');
    }
}
