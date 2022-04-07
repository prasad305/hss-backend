<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuditionMarksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audition_marks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('audition_id')->nullable();
            $table->unsignedBigInteger('judge_id')->nullable();
            $table->unsignedBigInteger('participant_id')->nullable();
            $table->unsignedBigInteger('jury_id')->nullable();
            $table->string('marks')->nullable();
            $table->text('comments')->nullable();
            $table->integer('status')->default(0)->comment('0 = unactive, 1= active');
            $table->boolean('participant_status')->default(0)->comment('0 = rejected, 1= selected');
            $table->integer('selected_status')->default(0)->comment('0 = selected, 1= rejected');
            $table->text('message')->nullable();
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
        Schema::dropIfExists('audition_marks');
    }
}
