<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuditionEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audition_events', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('created_by_id')->nullable();
            $table->unsignedBigInteger('star_id')->nullable();
            $table->string('title')->nullable();
            $table->timestamp('registration_end_date')->nullable();
            $table->timestamp('registration_start_date')->nullable();
            $table->longText('description')->nullable();
            $table->string('venue')->nullable();
            $table->integer('total_seat')->nullable();
            $table->string('banner')->nullable();
            $table->integer('participant_number')->nullable();
            $table->string('video')->nullable();
            $table->timestamp('date')->nullable();
            $table->time('time')->nullable();
            $table->float('fee')->nullable();
            $table->boolean('status')->default(0)->comment('0 = deactive, 1 = active');
            $table->float('total_amount')->nullable();
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
        Schema::dropIfExists('audition_events');
    }
}
