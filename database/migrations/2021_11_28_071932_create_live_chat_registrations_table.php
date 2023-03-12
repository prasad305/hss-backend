<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLiveChatRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('live_chat_registrations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('live_chat_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('payment_method')->nullable();
            $table->boolean('payment_status')->nullable();
            $table->timestamp('payment_date')->nullable();
            $table->float('amount')->nullable();
            $table->string('card_holder_name')->nullable();
            $table->string('account_no')->nullable();
            $table->time('live_chat_start_time')->nullable();
            $table->time('live_chat_end_time')->nullable();
            $table->string('taken_time')->nullable();
            $table->date('live_chat_date')->nullable();
            $table->string('video')->nullable();
            $table->string('room_id')->nullable();
            $table->boolean('getSlot')->default(0);
            $table->integer('comment_count')->nullable();
            $table->integer('publish_status')->nullable();
            $table->timestamps();

            $table->foreign('live_chat_id')->references('id')->on('live_chats')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('live_chat_registrations');
    }
}
