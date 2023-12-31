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
            $table->unsignedBigInteger('sub_category_id')->nullable();
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->string('meetup_type')->nullable();
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->date('event_date')->nullable();
            $table->text('event_link')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->longText('description')->nullable();
            $table->longText('instruction')->nullable();
            $table->string('venue')->nullable();
            $table->integer('total_seat')->nullable();
            $table->string('banner')->nullable();
            $table->string('video')->nullable();
            $table->date('reg_start_date')->nullable();
            $table->date('reg_end_date')->nullable();
            $table->float('fee')->nullable();
            $table->integer('status')->default(0)->comment('0 = pending, 1 = star_approval, 2 = posted by Manager Admin, 9 = completed, 10 = remove/delete, 11 = rejeced by Star, 22 = rejected by Manager Admin');
            $table->timestamps();

            $table->foreign('created_by_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('star_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('admin_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('sub_category_id')->references('id')->on('sub_categories')->onDelete('cascade');
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
