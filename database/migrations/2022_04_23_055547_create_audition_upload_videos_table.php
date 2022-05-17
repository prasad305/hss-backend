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
            $table->unsignedBigInteger('round_id')->nullable();
            $table->unsignedBigInteger('jury_id')->nullable();
            $table->unsignedBigInteger('judge_id')->nullable();
            $table->unsignedBigInteger('audition_admin_id')->nullable();
            $table->string('video')->nullable();

            $table->string('approval_status')->nullable()->default(0)->comment('0 = not reviewed , 1 = approved, 2 = rejected');
            $table->integer('judge_approval_status')->nullable()->default(0);

            $table->string('audition_admin_comment')->nullable();
            $table->string('judge_comment')->nullable();
            $table->string('jury_comment')->nullable();
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
