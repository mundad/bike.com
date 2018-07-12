<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('rental_id');
            $table->tinyInteger('paymant_method');
            $table->text('deposit');
            $table->dateTime('date_time_in');
            $table->dateTime('date_time_out');
            $table->float('total');
            $table->float('insurance');
            $table->float('dis');
            $table->float('tax');
            $table->float('totalmath');
            $table->Integer('delete_user_id')->default(0);
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
        Schema::dropIfExists('sales');
    }
}
