<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWalletsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wallets', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->string('title')->nullable();
            $table->string('type')->nullable();
            $table->integer('club_points')->default(0);
            $table->integer('love_points')->default(0);
            $table->integer('auditions')->default(0);
            $table->integer('learning_session')->default(0);
            $table->integer('live_chats')->default(0);
            $table->integer('meetup')->default(0);
            $table->integer('greetings')->default(0);
            $table->integer('qna')->default(0);
            $table->float('price')->default(0);
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
        Schema::dropIfExists('wallets');
    }
}
