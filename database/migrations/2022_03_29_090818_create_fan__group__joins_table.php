<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFanGroupJoinsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fan__group__joins', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->integer('fan_group_id')->nullable();
            $table->integer('star_id')->nullable();
            $table->string('star_name')->nullable();
            $table->integer('warning_count')->nullable();
            $table->integer('approveStatus')->nullable();
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
        Schema::dropIfExists('fan__group__joins');
    }
}
