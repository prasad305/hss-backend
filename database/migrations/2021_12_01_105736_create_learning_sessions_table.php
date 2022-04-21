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
            $table->unsignedBigInteger('created_by_id')->nullable();
            $table->unsignedBigInteger('star_id')->nullable();
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->timestamp('registration_end_date')->nullable();
            $table->timestamp('registration_start_date')->nullable();
            $table->text('description')->nullable();
            $table->string('venue')->nullable();
            $table->string('total_seat')->nullable();
            $table->string('banner')->nullable();
            $table->string('participant_number')->nullable();
            $table->string('video')->nullable();
            $table->timestamp('date')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->float('fee')->nullable();
            $table->string('room_id')->nullable();
            $table->float('star_approval')->default(0)->comment('0 = deactive, 1 = active');
            $table->boolean('status')->default(0)->comment('0 = deactive, 1 = active');
            $table->string('total_amount')->nullable();
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
