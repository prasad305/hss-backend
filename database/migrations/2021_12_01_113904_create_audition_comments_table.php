<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuditionCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audition_comments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('audition_event_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('parent_comment_id')->nullable();
            $table->string('comment')->nullable();
            $table->integer('react_no')->nullable();
            $table->integer('status')->nullable();
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
        Schema::dropIfExists('audition_comments');
    }
}
