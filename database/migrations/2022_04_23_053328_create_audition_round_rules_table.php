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
            $table->integer('round_num')->nullable();
            $table->unsignedBigInteger('audition_rules_id');
            $table->integer('jury_or_judge')->nullable()->comment('0 = jury,1= judge');
            $table->double('jury_or_judge_mark')->nullable();
            $table->double('user_vote_mark')->nullable();
            $table->integer('mark_live_or_offline')->nullable()->comment('0 = offline,1= live');
            $table->integer('wildcard')->nullable()->comment('0 = no , 1= yes');
            $table->integer('wildcard_round')->nullable();
            $table->integer('appeal')->nullable()->comment('0 = no, 1= yes');
            $table->integer('video_feed')->nullable()->comment('0 = no, 1= yes');
            $table->text('title')->nullable();
            $table->longText('description')->nullable();
            $table->longText('video_instruction')->nullable();
            $table->timestamp('video_start_time')->nullable();
            $table->timestamp('video_end_time')->nullable();
            $table->text('instruction')->nullable();
            $table->integer('num_of_videos')->nullable();
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
