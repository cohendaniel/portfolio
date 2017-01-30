<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBeerCheesePairTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('beer_cheese_pairs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('beer_id')->unsigned();
            $table->foreign('beer_id')->references('id')->on('beers');
            $table->integer('cheese_id')->unsigned();
            $table->foreign('cheese_id')->references('id')->on('cheeses');
            $table->text('comments');
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
        Schema::dropIfExists('beer_cheese_pairs');
    }
}
