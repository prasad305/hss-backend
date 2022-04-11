<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuditionParticipantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audition_participants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->unsignedBigInteger('audition_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('jury_id')->nullable();
            $table->unsignedBigInteger('marks_id')->nullable();
            $table->integer('winning_status')->nullable()->comment(' 0 = fail , 1 = win');
            $table->text('video_url')->nullable();
            $table->text('certificates')->nullable();
            $table->integer('accept_status')->comment('0 = reject, 1= except');
            $table->text('comments')->nullable();
            $table->integer('filter_status')->nullable()->comment('0 = not-filtered, 1= filter');
            $table->integer('send_manager_admin')->default(0)->comment('0 = unsend, 1= send');
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
        Schema::dropIfExists('audition_participants');
    }
}
