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
            $table->string('room_id')->nullable();
            $table->longText('description')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->integer('min_member')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('sub_category_id')->nullable();
            $table->integer('max_member')->nullable();
            $table->unsignedBigInteger('created_by')->nullable()->comment('created_by_id');
            $table->unsignedBigInteger('my_star')->nullable()->comment('my_star_id');
            $table->integer('my_star_status')->nullable()->comment('1 = Accept, 0 = Not Accept, 2 = Ignore');
            $table->unsignedBigInteger('another_star')->nullable()->comment('another_star_id');
            $table->unsignedBigInteger('another_star_admin_id')->nullable();
            $table->integer('another_star_status')->nullable()->comment('1 = Accept, 0 = Not Accept, 2 = Ignore');
            $table->string('banner')->nullable();
            $table->integer('club_points')->nullable();
            $table->longText('my_user_join')->nullable()->comment('my_user_join_by_id');
            $table->longText('another_user_join')->nullable()->comment('another_user_join_by_id');
            $table->integer('join_approval_status')->nullable()->comment('1 = Anyone can Join, 0 = Join by Admin/Star');
            $table->integer('post_approval_status')->nullable()->comment('1 = Anyone can Post, 0 = Post by Admin/Star');
            $table->integer('status')->nullable()->comment('1 = active, 0 = inactive, 2=manager Approval');
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('sub_category_id')->references('id')->on('sub_categories')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('my_star')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('another_star')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('another_star_admin_id')->references('id')->on('users')->onDelete('cascade');

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
