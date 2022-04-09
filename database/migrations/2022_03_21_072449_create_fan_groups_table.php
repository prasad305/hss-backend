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
            $table->text('description')->nullable();
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->string('min_member')->nullable();
            $table->string('max_member')->nullable();
            $table->string('created_by')->nullable();
            $table->string('my_star')->nullable();
            $table->string('my_star_status')->nullable();
            $table->string('another_star')->nullable();
            $table->string('another_star_admin_id')->nullable();
            $table->string('another_star_status')->nullable();
            $table->string('banner')->nullable();
            $table->string('my_user_join')->nullable();
            $table->string('another_user_join')->nullable();
            $table->integer('join_approval_status')->nullable();
            $table->integer('post_approval_status')->nullable();
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
        Schema::dropIfExists('fan_groups');
    }
}
