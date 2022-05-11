<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuditionJudgeInstructionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audition_judge_instructions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('audition_id')->nullable();
            $table->unsignedBigInteger('star_id')->nullable();
            $table->unsignedBigInteger('round_id')->nullable();
            $table->string('title')->nullable();
            $table->string('banner')->nullable();
            $table->string('video')->nullable();
            $table->integer('status')->nullable();
            $table->longText('description')->nullable();
            $table->timestamp('time_boundary')->nullable();
            $table->timestamp('date')->nullable();
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
        Schema::dropIfExists('audition_judge_instructions');
    }
}
