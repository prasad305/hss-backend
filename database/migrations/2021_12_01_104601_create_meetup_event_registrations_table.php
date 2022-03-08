<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMeetupEventRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meetup_event_registrations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('meetup_event_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('payment_status')->nullable();
            $table->string('payment_date')->nullable();
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
        Schema::dropIfExists('meetup_event_registrations');
    }
}
