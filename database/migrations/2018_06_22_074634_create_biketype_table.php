<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBiketypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('biketypes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('info');
            $table->double('price_h',8,2);
            $table->double('price_d',8,2);
            $table->double('insurance',8,2);
            $table->softDeletes();
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
        Schema::dropIfExists('biketype');
    }
}
