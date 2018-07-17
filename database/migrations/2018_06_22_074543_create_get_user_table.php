<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGetUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_gets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('phone',20)->unique()->index();
            $table->string('name',50)->default('not enter');
            $table->string('second_name',50)->default('not enter');
            $table->string('address',250)->default('not enter');
            $table->string('email',250)->default('not@ent.er');
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
        Schema::dropIfExists('get_user');
    }
}
