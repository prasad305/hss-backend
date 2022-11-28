<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoveReactPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('love_react_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('video_id')->nullable();
            $table->unsignedBigInteger('audition_id')->nullable();
            $table->unsignedBigInteger('round_info_id')->nullable();
            $table->integer('react_num')->nullable();
            $table->string('type')->nullable();
            $table->string('cardHolderName')->nullable();
            $table->string('cardNumber')->nullable();
            $table->string('expireDate')->nullable();
            $table->string('ccv')->nullable();
            $table->double('fee', 8, 2)->nullable();
            $table->integer('status')->nullable();
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
        Schema::dropIfExists('love_react_payments');
    }
}
