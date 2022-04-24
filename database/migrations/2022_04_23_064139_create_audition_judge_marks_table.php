<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuditionJudgeMarksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audition_judge_marks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('judge_id')->nullable();
            $table->unsignedBigInteger('participant_id')->nullable();
            $table->string('marks')->nullable();
            $table->string('comments')->nullable();
            $table->string('status')->nullable()->default(0);
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
        Schema::dropIfExists('audition_judge_marks');
    }
}
