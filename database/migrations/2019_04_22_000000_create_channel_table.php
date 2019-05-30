<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChannelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('channel', function (Blueprint $table) {
            $table->primary(array('game_id', 'user_id'));
            $table->integer('game_id');
            $table->integer('user_id');
            $table->integer('is_host')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('channel');
    }
}
