<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLiveChatRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('live_chat_rooms', function (Blueprint $table) {
            $table->id();
            $table->integer('live_chat_id')->nullable();
            $table->integer('star_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->string('room_id')->nullable();
            $table->timestamp('time')->nullable();
            $table->boolean('status')->nullable();
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
        Schema::dropIfExists('live_chat_rooms');
    }
}
