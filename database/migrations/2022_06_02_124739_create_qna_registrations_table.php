<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQnaRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qna_registrations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('qna_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('payment_method')->nullable();
            $table->boolean('payment_status')->nullable();
            $table->timestamp('payment_date')->nullable();
            $table->double('amount')->nullable();
            $table->string('card_holder_name')->nullable();
            $table->string('account_no')->nullable();
            $table->time('qna_start_time')->nullable();
            $table->time('qna_end_time')->nullable();
            $table->timestamp('qna_date')->nullable();
            $table->string('room_id')->nullable();
            $table->integer('comment_count')->nullable();
            $table->integer('publish_status')->nullable();
            $table->timestamps();

            $table->foreign('qna_id')->references('id')->on('qn_a_s')->onDelete('cascade');
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
        Schema::dropIfExists('qna_registrations');
    }
}
