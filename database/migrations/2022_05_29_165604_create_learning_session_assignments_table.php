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
            $table->integer('event_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->string('video')->nullable();
            $table->integer('mark')->default(0);
            $table->longText('comment')->nullable();
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
        Schema::dropIfExists('learning_session_assignments');
    }
}
