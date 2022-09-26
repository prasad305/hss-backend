<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuditionRoundInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audition_round_infos', function (Blueprint $table) {
            $table->id();
            $table->integer('round_num')->nullable();
            $table->unsignedBigInteger('audition_id')->nullable();
            $table->unsignedBigInteger('audition_info_id')->nullable();
            $table->integer('has_jury_or_judge_mark')->nullable()->comment('0 = jury,1= judge');
            $table->integer('jury_or_judge_mark')->nullable()->comment('mark in percentage');
            $table->integer('has_user_vote_mark')->default(0)->comment('0 = no , 1= yes');
            $table->integer('user_vote_mark')->default(0)->comment('mark in percentage');
            $table->integer('mark_live_or_offline')->nullable()->comment('0 = offline,1= live');
            $table->integer('wildcard')->nullable()->comment('0 = no , 1= yes');
            $table->integer('round_type')->nullable()->comment('0 = offline , 1= online')->default(0);
            $table->longText('room_id')->nullable();
            $table->integer('videofeed_status')->default(0)->comment('0 = unpublished , 1 = published from manager admin');
            $table->integer('wildcard_round')->nullable();
            $table->integer('appeal')->nullable()->comment('0 = no, 1= yes');
            $table->integer('video_feed')->nullable()->comment('0 = no, 1= yes');
            $table->integer('video_duration')->nullable();
            $table->integer('video_slot_num')->nullable();
            $table->date('round_start_date')->nullable();
            $table->date('round_end_date')->nullable();
            $table->date('instruction_prepare_start_date')->nullable();
            $table->date('instruction_prepare_end_date')->nullable();
            $table->date('video_upload_start_date')->nullable();
            $table->date('video_upload_end_date')->nullable();
            $table->date('jury_or_judge_mark_start_date')->nullable();
            $table->date('jury_or_judge_mark_end_date')->nullable();
            $table->date('result_publish_start_date')->nullable();
            $table->date('result_publish_end_date')->nullable();

            $table->integer('appeal_video_duration')->nullable();
            $table->integer('appeal_video_slot_num')->nullable();

            $table->date('appeal_start_date')->nullable();
            $table->date('appeal_end_date')->nullable();

            $table->date('appeal_video_upload_start_date')->nullable();
            $table->date('appeal_video_upload_end_date')->nullable();
            $table->date('appeal_jury_or_judge_mark_start_date')->nullable();
            $table->date('appeal_jury_or_judge_mark_end_date')->nullable();

            $table->date('appeal_result_publish_start_date')->nullable();
            $table->date('appeal_result_publish_end_date')->nullable();

            $table->integer('manager_status')->default(0)->comment('0 = not send, 1 = send to manager, 2 = send to user');
            $table->integer('appeal_manager_status')->default(0)->comment('0 = not send, 1 = send to manager, 2 = send to user');
            $table->integer('status')->default(0)->comment('0 = inactive, 1= running , 2=completed');
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
        Schema::dropIfExists('audition_round_infos');
    }
}
