<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGameTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('game', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('host_user_id');
            $table->integer('status');
            $table->integer('onboard_card_id')->nullable();
            $table->string('unplayed')->nullable();
            $table->string('remaining')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('game');
    }
}
