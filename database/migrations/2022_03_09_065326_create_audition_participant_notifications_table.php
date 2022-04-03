<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuditionParticipantNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audition_participant_notifications', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('type')->nullable();
            $table->unsignedBigInteger('perticipant_id')->nullable();
            $table->unsignedBigInteger('audition_id')->nullable();
            $table->integer('round_status')->nullable()->comment(' 0 = 1st round , 1 = 2nd round, 3 = 3rd round');
            $table->string('title')->nullable();
            $table->text('details')->nullable();
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
        Schema::dropIfExists('audition_participant_notifications');
    }
}
