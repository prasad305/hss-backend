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
            $table->string('created_by')->nullable();
            $table->string('max_member')->nullable();
            $table->string('star_one')->nullable();
            $table->string('star_one_status')->nullable();
            $table->string('star_two')->nullable();
            $table->string('star_two_status')->nullable();
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
