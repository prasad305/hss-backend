<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQnaMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qna_messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sender_id')->nullable();
            $table->unsignedBigInteger('qna_id')->nullable();
            $table->string('sender_name')->nullable();
            $table->longText('room_id')->nullable();
            $table->string('msg_type')->nullable();
            $table->string('sender_image')->nullable();
            $table->string('media')->nullable();
            $table->longText('text')->nullable();
            $table->string('time')->nullable();
            $table->integer('status')->nullable();
            $table->timestamps();

            $table->foreign('sender_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('qna_id')->references('id')->on('qn_a_s')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('qna_messages');
    }
}
