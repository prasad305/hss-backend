<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuditionRulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audition_rules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->integer('round_num')->default(0);
            $table->integer('judge_num')->default(0);
            $table->text('jury_groups')->nullable();
            $table->integer('event_period')->nullable();
            $table->integer('registration_period')->nullable();
            $table->integer('status')->default(1)->comment('0 = inactive, 1= active');
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
        Schema::dropIfExists('audition_rules');
    }
}
