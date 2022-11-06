<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_infos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->longText('user_fan_group_id')->nullable();
            $table->string('nid')->nullable();
            $table->string('passport')->nullable();
            $table->string('gender')->nullable();
            $table->string('country')->nullable();
            $table->date('dob')->nullable();
            $table->text('occupation')->nullable();
            $table->text('company')->nullable();
            $table->text('edu_level')->nullable();
            $table->text('institute')->nullable();
            $table->text('subject')->nullable();
            $table->text('position')->nullable();
            $table->integer('salery_range')->default(0);
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
        Schema::dropIfExists('user_infos');
    }
}
