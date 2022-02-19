<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuditionReactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audition_reacts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('audition_event_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('react')->default(0)->comment('0=like, 1=love, 2=other');
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
        Schema::dropIfExists('audition_reacts');
    }
}
