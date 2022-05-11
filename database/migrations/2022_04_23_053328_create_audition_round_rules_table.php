<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuditionRoundRulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audition_round_rules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('audition_rules_id');
            $table->double('judge_mark')->nullable();
            $table->double('jury_mark')->nullable();
            $table->double('user_vote_mark')->nullable();
            $table->text('title')->nullable();
            $table->text('description')->nullable();
            $table->text('video_instruction')->nullable();
            $table->string('num_of_videos')->nullable();
            $table->timestamp('uploade_date')->nullable();
            $table->text('banner')->nullable();
            $table->text('video')->nullable();
            $table->integer('status')->default(0)->comment('0 = unactive, 1= active');
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
        Schema::dropIfExists('audition_round_rules');
    }
}


