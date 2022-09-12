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
            $table->unsignedBigInteger('audition_id')->nullable();
            $table->unsignedBigInteger('round_info_id')->nullable();
            $table->unsignedBigInteger('audition_uploads_video_id')->nullable();
            $table->unsignedBigInteger('judge_id')->nullable();
            $table->double('judge_mark', 8, 2)->nullable();
            $table->string('judge_commnent')->nullable();
            $table->tinyInteger('status')->nullable();
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
