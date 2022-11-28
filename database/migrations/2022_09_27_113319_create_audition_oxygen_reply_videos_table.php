<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuditionOxygenReplyVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audition_oxygen_reply_videos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('audition_id')->nullable();
            $table->unsignedBigInteger('round_info_id')->nullable();
            $table->unsignedBigInteger('participant_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('oxygen_video_id')->nullable();
            $table->string('reply_video')->nullable();
            $table->integer('status')->default(0);
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
        Schema::dropIfExists('audition_oxygen_reply_videos');
    }
}
