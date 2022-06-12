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
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->unsignedBigInteger('star_id')->nullable();
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->timestamp('registration_start_date')->nullable();
            $table->timestamp('registration_end_date')->nullable();
            $table->longText('description')->nullable();
            $table->longText('instruction')->nullable();
            $table->string('video')->nullable();
            $table->string('banner')->nullable();
            $table->integer('participant_number')->nullable();
            $table->timestamp('event_date')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->double('fee',8,2)->nullable();
            $table->string('room_id')->nullable();
            $table->integer('assignment')->default(0);
            $table->timestamp('assignment_reg_end_date')->nullable();
            $table->timestamp('assignment_reg_start_date')->nullable();
            $table->double('assignment_fee',8,2)->nullable();
            $table->integer('assignment_video_slot_number')->nullable();
            $table->longText('assignment_instruction')->nullable();
            $table->integer('status')->default(0)->comment('0 = pending, 1 = star_approval, 2 = posted by Manager Admin, 3 = evaluation, 9 = completed, 10 = removed, 11 = rejeced by Star, 22 = rejected by Manager Admin');
            $table->double('total_amount',8,2)->nullable();
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
