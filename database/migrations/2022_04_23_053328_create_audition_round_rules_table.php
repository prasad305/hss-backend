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
            $table->unsignedBigInteger('audition_rules_id')->nullable();
            $table->integer('has_jury_or_judge_mark')->nullable()->comment('0 = jury,1= judge');
            $table->integer('jury_or_judge_mark')->nullable()->comment('mark in percentage');
            $table->integer('has_user_vote_mark')->default(0)->comment('0 = no , 1= yes');
            $table->integer('user_vote_mark')->default(0)->comment('mark in percentage');
            $table->integer('mark_live_or_offline')->nullable()->comment('0 = offline,1= live');
            $table->integer('wildcard')->nullable()->comment('0 = no , 1= yes');
            $table->integer('wildcard_round')->nullable();
            $table->integer('appeal')->nullable()->comment('0 = no, 1= yes');
            $table->integer('video_feed')->nullable()->comment('0 = no, 1= yes');
            $table->integer('video_duration')->nullable();

            $table->integer('round_period')->nullable();
            $table->integer('video_slot_num')->nullable();
            $table->integer('instruction_prepare_period')->nullable();
            $table->integer('video_upload_period')->nullable();
            $table->integer('jury_or_judge_mark_period')->nullable();
            $table->integer('result_publish_period')->nullable();
            $table->integer('appeal_period')->nullable();
            $table->integer('appeal_result_publish_period')->nullable();

            $table->integer('status')->default(0)->comment('0 = inactive, 1= active');
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
