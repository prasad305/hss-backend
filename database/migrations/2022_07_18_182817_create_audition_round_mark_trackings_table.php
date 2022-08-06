<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuditionRoundMarkTrackingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audition_round_mark_trackings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('round_info_id')->nullable();
            $table->unsignedBigInteger('audition_id')->nullable();
            $table->string('type')->default('general')->comment('normal video = general , appeal video = appeal');
            $table->string('result_message')->nullable()->comment();
            $table->double('avg_mark', 8,2)->nullable();
            $table->integer('wining_status')->default(0)->comment('default 0 , pass = 1');
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
        Schema::dropIfExists('audition_round_mark_trackings');
    }
}
