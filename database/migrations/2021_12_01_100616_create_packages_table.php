<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->integer('club_points')->nullable();
            $table->integer('love_points')->nullable();
            $table->integer('auditions')->default(0);
            $table->integer('learning_session')->default(0);
            $table->integer('live_chats')->default(0);
            $table->integer('meetup')->default(0);
            $table->integer('greetings')->default(0);
            $table->integer('qna')->default(0);
            $table->string('color_code')->nullable();
            $table->integer('status')->default(0);
            $table->float('price')->nullable();
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
        Schema::dropIfExists('packages');
    }
}
