<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMeetupEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meetup_events', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('created_by_id')->nullable();
            $table->unsignedBigInteger('star_id')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->string('meetup_type')->nullable();
            $table->string('title')->nullable();
            $table->text('event_link')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->longText('description')->nullable();
            $table->string('venue')->nullable();
            $table->integer('total_seat')->nullable();
            $table->string('banner')->nullable();
            $table->integer('participant_number')->nullable();
            $table->string('video')->nullable();
            $table->date('date')->nullable();
            $table->time('time')->nullable();
            $table->float('fee')->nullable();
            $table->boolean('star_approval')->default(0)->comment('0 = pending, 1 = approved');
            $table->boolean('manager_approval')->default(0)->comment('0 = pending, 1 = approved');
            $table->boolean('status')->default(0)->comment('0 = deactive, 1 = active');
            $table->unsignedBigInteger('total_amount')->nullable();
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
        Schema::dropIfExists('meetup_events');
    }
}
