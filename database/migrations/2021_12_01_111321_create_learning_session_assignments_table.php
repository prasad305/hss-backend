<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLearningSessionAssignmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('learning_session_assignments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('event_id')->nullable();
            $table->unsignedBigInteger('evaluation_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('video')->nullable();
            $table->double('mark', 8, 2)->default(0);
            $table->longText('comment')->nullable();
            $table->integer('status')->default(0)->comment('1=selected,2=rejected');
            $table->integer('send_to_manager')->default(0);
            $table->integer('send_to_star')->default(0);
            $table->integer('send_to_user')->default(0);
            $table->timestamps();

            $table->foreign('event_id')->references('id')->on('learning_sessions')->onDelete('cascade');
            $table->foreign('evaluation_id')->references('id')->on('learning_session_evaluations')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('learning_session_assignments');
    }
}
