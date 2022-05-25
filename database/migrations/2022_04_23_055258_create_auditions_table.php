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
            $table->unsignedBigInteger('audition_rules_id')->nullable();
            $table->unsignedBigInteger('audition_round_rules_id')->nullable();
            $table->unsignedBigInteger('creater_id')->nullable();
            $table->unsignedBigInteger('audition_admin_id')->nullable();
            $table->unsignedBigInteger('manager_admin_id')->nullable();
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->longText('description')->nullable();
            $table->string('banner')->nullable();
            $table->string('video')->nullable();
            $table->integer('round_status')->nullable();
            $table->string('template_id')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->integer('status')->default(0)->comment('3 = live');
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
