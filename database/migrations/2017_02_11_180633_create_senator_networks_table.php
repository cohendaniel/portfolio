<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSenatorNetworksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('senator_networks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('source_id');
            $table->string('source_name');
            $table->string('source_handle');
            $table->string('source_party');
            $table->string('source_state');
            $table->integer('target_id');
            $table->string('target_name');
            $table->string('target_handle');
            $table->string('target_party');
            $table->string('target_state');
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
        Schema::dropIfExists('senator_networks');
    }
}
