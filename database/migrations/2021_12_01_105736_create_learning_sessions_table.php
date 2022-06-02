<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLearningSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('learning_sessions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('created_by_id')->nullable();
            $table->unsignedBigInteger('star_id')->nullable();
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->timestamp('registration_end_date')->nullable();
            $table->timestamp('registration_start_date')->nullable();
            $table->text('description')->nullable();
            $table->string('venue')->nullable();
            $table->integer('total_seat')->nullable();
            $table->string('banner')->nullable();
            $table->integer('participant_number')->nullable();
            $table->string('video')->nullable();
            $table->timestamp('date')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->float('fee')->nullable();
            $table->string('room_id')->nullable();
            $table->string('assignment')->default(0);
            $table->string('assignment_reg_end_date')->nullable();
            $table->string('assignment_reg_start_date')->nullable();
            $table->string('assignment_fee')->nullable();
            $table->string('assignment_video_slot_number')->nullable();
            $table->string('assignment_instruction')->nullable();
            $table->float('star_approval')->default(0)->comment('0 = deactive, 1 = active');
            $table->integer('status')->default(0)->comment('0 = pending, 1 = star_approval, 2 = posted by Manager Admin, 3 = evaluation, 9 = completed, 10 = removed, 11 = rejeced by Star, 22 = rejected by Manager Admin');
            $table->float('total_amount')->nullable();
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
        Schema::dropIfExists('learning_sessions');
    }
}
