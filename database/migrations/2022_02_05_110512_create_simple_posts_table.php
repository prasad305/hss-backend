<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSimplePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('simple_posts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('created_by_id')->nullable();
            $table->unsignedBigInteger('star_id')->nullable();
            $table->string('title')->nullable();
            $table->longText('description')->nullable();
            $table->string('image')->nullable();
            $table->string('video')->nullable();
            $table->integer('star_approval')->default(0);
            $table->integer('status')->default(0);
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
        Schema::dropIfExists('simple_posts');
    }
}
