<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('type')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('event_id')->nullable();
            $table->unsignedBigInteger('category_id')->default(0);
            $table->unsignedBigInteger('sub_category_id')->default(0);
            $table->integer('comment_number')->default(0);
            $table->integer('react_number')->default(0);
            $table->integer('share_number')->default(0);
            $table->string('title')->nullable();
            $table->longText('details')->nullable();
            $table->string('share_link')->nullable();
            $table->longText('react_provider')->nullable();
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
        Schema::dropIfExists('posts');
    }
}
