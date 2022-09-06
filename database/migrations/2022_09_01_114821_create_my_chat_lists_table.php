<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMyChatListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('my_chat_lists', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('title')->nullable();
            $table->string('type')->nullable();
            $table->unsignedBigInteger('fan_group_id')->nullable();
            $table->unsignedBigInteger('qna_id')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('my_chat_lists');
    }
}
