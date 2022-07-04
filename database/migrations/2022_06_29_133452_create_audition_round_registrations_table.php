<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuditionRoundRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audition_round_registrations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('audition_id')->nullable();
            $table->unsignedBigInteger('audition_round_info_id')->nullable();

            $table->integer('status')->default(0)->comment('0 = default, 1= pass, 2 = fail');

            $table->string('mark')->nullable();
            $table->string('user_vote_mark')->nullable();
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
        Schema::dropIfExists('audition_round_registrations');
    }
}
