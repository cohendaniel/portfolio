<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSlotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('sqlite2')->create('slots', function (Blueprint $table) {
            $table->increments('id');
            $table->text('name');
            $table->date('date');
            $table->time('time');
            $table->integer('number')->unsigned();
            $table->integer('item_id')->unsigned()->nullable()->index();
            $table->integer('event_id')->unsigned()->index();
            $table->integer('user_id')->unsigned()->index();
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
        Schema::dropIfExists('slots');
    }
}
