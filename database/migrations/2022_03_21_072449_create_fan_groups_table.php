<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFanGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fan_groups', function (Blueprint $table) {
            $table->id();
            $table->string('group_name')->nullable();
            $table->string('slug')->nullable();
            $table->longText('description')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->integer('min_member')->nullable();
            $table->integer('max_member')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('my_star')->nullable();
            $table->integer('my_star_status')->nullable();
            $table->integer('another_star')->nullable();
            $table->integer('another_star_admin_id')->nullable();
            $table->integer('another_star_status')->nullable();
            $table->string('banner')->nullable();
            $table->longText('my_user_join')->nullable();
            $table->longText('another_user_join')->nullable();
            $table->integer('join_approval_status')->nullable();
            $table->integer('post_approval_status')->nullable();
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
        Schema::dropIfExists('fan_groups');
    }
}
