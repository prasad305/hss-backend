<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuditionParticipantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audition_participants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('audition_round_rules_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('audition_id')->nullable();
            $table->Integer('round_info_id')->nullable();
            $table->integer('wining_status')->nullable();
            $table->string('certificates')->nullable();
            $table->integer('status')->default(0)->comment('0 = inactive, 1= active');

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
        Schema::dropIfExists('audition_participants');
    }
}
