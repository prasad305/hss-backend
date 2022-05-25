<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLiveChatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('live_chats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('created_by_id')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('star_id')->nullable();
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->longText('description')->nullable();
            $table->longText('instruction')->nullable();
            $table->timestamp('date')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->unsignedBigInteger('slot_counter')->nullable();
            $table->string('banner')->nullable();
            $table->string('video')->nullable();
            $table->integer('total_seat')->nullable();
            $table->float('total_amount')->nullable();
            $table->float('fee')->nullable();
            $table->integer('participant_number')->nullable();
            $table->timestamp('registration_start_date')->nullable();
            $table->timestamp('registration_end_date')->nullable();
            $table->string('max_time_per_person')->nullable();
            $table->boolean('publish_status')->default(1);
            $table->boolean('star_approve_status')->default(0);
            $table->integer('status')->default(0)->comment('0 = pending, 1 = star_approval, 2 = posted by Manager Admin, 9 = completed, 10 = removed, 11 = rejeced by Star, 22 = rejected by Manager Admin');
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
        Schema::dropIfExists('live_chats');
    }
}
