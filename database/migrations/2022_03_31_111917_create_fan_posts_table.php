<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFanPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fan_posts', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->nullable();
            $table->string('fan_group_id')->nullable();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->string('star_id')->nullable();
            $table->string('star_name')->nullable();
            $table->string('like_count')->nullable();
            $table->string('video')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('fan_posts');
    }
}
