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
            $table->integer('user_id')->nullable();
            $table->integer('fan_group_id')->nullable();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->integer('star_id')->nullable();
            $table->string('star_name')->nullable();
            $table->integer('like_count')->nullable();
            $table->longText('user_like_id')->nullable();
            $table->string('video')->nullable();
            $table->integer('status')->nullable()->comment('1 = active, 0 = inactive');
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
