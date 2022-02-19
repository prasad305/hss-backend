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
            $table->string('payment_status')->nullable();
            $table->string('payment_date')->nullable();
            $table->float('amount')->nullable();
            $table->string('card_holder_name')->nullable();
            $table->string('account_no')->nullable();
            $table->timestamp('live_chat_start_time')->nullable();
            $table->timestamp('live_chat_end_time')->nullable();
            $table->timestamp('live_chat_date')->nullable();
            $table->string('video')->nullable();
            $table->string('comment_count')->nullable();
            $table->string('publish_status')->nullable();
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
        Schema::dropIfExists('live_chat_registrations');
    }
}
