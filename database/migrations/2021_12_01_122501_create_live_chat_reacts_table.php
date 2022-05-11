<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLiveChatReactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('live_chat_reacts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('live_chat_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->integer('react')->default(0)->comment('0=like, 1=love, 2=other');
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
        Schema::dropIfExists('live_chat_reacts');
    }
}
