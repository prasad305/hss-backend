<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilterVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('filter_videos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('audition_id')->nullable();
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->unsignedBigInteger('participant_id')->nullable();
            $table->text('comments')->nullable();
            $table->integer('accept_status')->nullable()->comment('0 = rejected, 1 = accepted');
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
        Schema::dropIfExists('filter_videos');
    }
}
