<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuditionUploadVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audition_upload_videos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('audition_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('round_info_id')->nullable();
            $table->string('judge_id')->default('[]');
            $table->unsignedBigInteger('audition_admin_id')->nullable();
            $table->unsignedBigInteger('group_a_per_jury_id')->nullable();
            $table->unsignedBigInteger('group_a_ran_jury_id')->nullable();
            $table->unsignedBigInteger('group_b_jury_id')->nullable();
            $table->unsignedBigInteger('group_c_jury_id')->nullable();
            $table->string('video')->nullable();
            $table->string('type')->default('general')->comment('general = normal videos , appeal = appeal videos');
            $table->integer('approval_status')->default(0)->comment('0 = not reviewed , 1 = approved, 2 = rejected');
            $table->string('audition_admin_comment')->nullable();
            $table->double('group_a_jury_mark', 8, 2)->nullable();
            $table->double('group_b_jury_mark', 8, 2)->nullable();
            $table->double('group_c_jury_mark', 8, 2)->nullable();
            $table->double('jury_final_mark', 8, 2)->nullable();
            $table->double('user_judge_total_mark', 8, 2)->nullable();
            $table->double('jury_or_judge_avg_mark', 8, 2)->nullable();
            $table->double('user_vote_avg_mark', 8, 2)->nullable();
            $table->string('comment')->nullable();
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
        Schema::dropIfExists('audition_upload_videos');
    }
}
