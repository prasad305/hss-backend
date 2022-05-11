<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLearningSessionRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('learning_session_registrations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('learning_session_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('payment_method')->nullable();
            $table->boolean('payment_status')->nullable();
            $table->timestamp('payment_date')->nullable();
            $table->float('amount')->nullable();
            $table->string('card_holder_name')->nullable();
            $table->string('account_no')->nullable();
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
        Schema::dropIfExists('learning_session_registrations');
    }
}
