<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('star_id')->nullable();
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->string('event_type')->nullable();
            $table->time('from')->nullable();
            $table->time('to')->nullable();
            $table->date('date')->nullable();
            $table->string('month')->nullable();
            $table->boolean('status')->default(0)->comment('0 = active , 1 = deactive');
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
        Schema::dropIfExists('schedules');
    }
}
