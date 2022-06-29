<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuditionInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audition_infos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('audition_id');
            $table->unsignedBigInteger('category_id');
            $table->integer('round_num')->default(0);
            $table->integer('judge_num')->default(0);
            $table->text('jury_groups')->nullable()->comment('how many groups & num of jury of each group');
            $table->date('registration_start_date')->nullable();
            $table->date('registration_end_date')->nullable();
            $table->date('event_start_date')->nullable();
            $table->date('event_end_date')->nullable();
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
        Schema::dropIfExists('audition_infos');
    }
}
