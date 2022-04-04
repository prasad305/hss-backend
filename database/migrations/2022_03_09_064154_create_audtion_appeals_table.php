<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAudtionAppealsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audtion_appeals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('audition_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->date('appeal_date_line')->nullable();
            $table->text('video_url')->nullable();
            $table->integer('status')->default(0)->comment('0 = unactive, 1= active');
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
        Schema::dropIfExists('audtion_appeals');
    }
}
