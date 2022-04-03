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
            $table->string('user_id')->nullable();
            $table->string('fan_group_id')->nullable();
            $table->string('star_id')->nullable();
            $table->string('star_name')->nullable();
            $table->string('warning_count')->nullable();
            $table->string('approveStatus')->nullable();
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
