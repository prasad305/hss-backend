<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuditionRoundInstructionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audition_round_instructions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('audition_id')->nullable();
            $table->unsignedBigInteger('round_info_id')->nullable();
            $table->longText('instruction')->nullable();
            $table->longText('description')->nullable();
            $table->string('video')->nullable();
            $table->string('image')->nullable();
            $table->string('document')->nullable();
            $table->date('submission_end_date')->nullable();
            $table->integer('send_to_user')->default(0)->comment('0= not send, 1= send');
            $table->integer('send_to_judge')->default(0)->comment('0= not send, 1= send');
            $table->integer('send_to_manager')->default(0)->comment('0= not send, 1= send');
            $table->integer('status')->default(0)->comment('0 = default');
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
        Schema::dropIfExists('audition_round_instructions');
    }
}
