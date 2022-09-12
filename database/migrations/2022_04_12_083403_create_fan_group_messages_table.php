<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFanGroupMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fan_group_messages', function (Blueprint $table) {
            $table->id();
            $table->integer('sender_id')->nullable();
            $table->string('room_id')->nullable();
            $table->string('sender_name')->nullable();
            $table->string('sender_image')->nullable();
            $table->integer('group_id')->nullable();
            $table->integer('position')->nullable();
            $table->longText('text')->nullable();
            $table->string('time')->nullable();
            $table->integer('status')->nullable();
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
        Schema::dropIfExists('fan_group_messages');
    }
}
