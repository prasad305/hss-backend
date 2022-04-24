<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuditionAssignJudgesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audition_assign_judges', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('judge_id')->nullable();
            $table->unsignedBigInteger('audition_id')->nullable();
            $table->integer('approved_by_judge')->default(0)->comment('0 = unapproved, 1= approved, 2 = rejected');
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
        Schema::dropIfExists('audition_assign_judges');
    }
}
