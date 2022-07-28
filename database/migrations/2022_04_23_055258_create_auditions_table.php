<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuditionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auditions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('audition_round_rules_id')->nullable();
            $table->unsignedBigInteger('active_round_info_id')->nullable();
            $table->unsignedBigInteger('creater_id')->nullable();
            $table->unsignedBigInteger('audition_admin_id')->nullable();
            $table->unsignedBigInteger('manager_admin_id')->nullable();
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->longText('instruction')->nullable();
            $table->longText('description')->nullable();
            $table->string('banner')->nullable();
            $table->string('video')->nullable();
            $table->string('pdf')->nullable();
            $table->integer('round_status')->nullable();
            $table->string('template_id')->nullable();
            $table->timestamp('user_reg_start_date')->nullable();
            $table->timestamp('user_reg_end_date')->nullable();
            $table->date('start_time')->nullable();
            $table->date('end_time')->nullable();
            $table->timestamp('final_result_published_date')->nullable();
            $table->double('fees')->nullable();
            $table->integer('participant')->nullable();
            $table->integer('status')->default(0)->comment('default/pending 0, 3 = live');
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
        Schema::dropIfExists('auditions');
    }
}
