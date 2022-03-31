<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->integer('created_by_id')->nullable();
            $table->longText('description')->nullable();
            $table->string('banner')->nullable();
            $table->string('video')->nullable();
            $table->integer('cost')->nullable();
            $table->string('type')->nullable();
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
        Schema::dropIfExists('event_profiles');
    }
}
