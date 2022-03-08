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
            $table->string('greeting_id')->nullable();
            $table->string('user_id')->nullable();
            $table->timestamp('notification_at')->nullable();
            $table->string('name')->nullable();
            $table->string('phone')->nullable();
            $table->timestamp('birth_date')->nullable();
            $table->timestamp('request_time')->nullable();
            $table->longText('greeting_contex')->nullable();
            $table->string('location')->nullable();
            $table->longText('additional_message')->nullable();
            $table->string('password')->nullable();
            $table->string('status')->default(0);
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
