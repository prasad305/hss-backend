<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssignJuriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assign_juries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('audition_id');
            $table->unsignedBigInteger('participant_id');
            $table->unsignedBigInteger('jury_id');
            $table->integer('status')->default(1)->comment('O = Unactive, 1 = Active');
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
        Schema::dropIfExists('assign_juries');
    }
}
