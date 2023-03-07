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
            $table->string('purpose')->nullable();
            $table->string('video')->nullable();
            $table->timestamp('request_time')->nullable();
            $table->longText('greeting_context')->nullable();
            // $table->string('phone')->nullable();
            // $table->timestamp('birth_date')->nullable();
            // $table->string('location')->nullable();
            // $table->string('password')->nullable();
            $table->longText('additional_message')->nullable();
            $table->integer('status')->default(0)->comment('0 = default ,1 = registration completed / payment completed, 2 = star uploaded greeting video, 3 = admin forwarded to user');
            $table->string('payment_method')->nullable();
            $table->boolean('payment_status')->nullable();
            $table->string('payment_date')->nullable();
            $table->float('amount')->nullable();
            $table->string('card_holder_name')->nullable();
            $table->string('account_no')->nullable();
            $table->timestamps();

            $table->foreign('greeting_id')->references('id')->on('greetings')->onDelete('cascade');
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
        Schema::dropIfExists('greetings_registrations');
    }
}
