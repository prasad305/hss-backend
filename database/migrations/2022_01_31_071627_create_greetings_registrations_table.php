<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGreetingsRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('greetings_registrations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('greeting_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamp('notification_at')->nullable();
            $table->string('name')->nullable();
            $table->string('phone')->nullable();
            $table->string('purpose')->nullable();
            $table->timestamp('birth_date')->nullable();
            $table->timestamp('request_time')->nullable();
            $table->longText('greeting_context')->nullable();
            $table->string('location')->nullable();
            $table->longText('additional_message')->nullable();
            $table->string('password')->nullable();
            $table->integer('status')->default(0)->comment('1 = registration completed / payment completed');

            $table->string('payment_method')->nullable();
            $table->boolean('payment_status')->nullable();
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
        Schema::dropIfExists('greetings_registrations');
    }
}
