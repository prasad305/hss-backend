<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuditionPromoInstructionSendInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audition_promo_instruction_send_infos', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('audition_promo_ins_id')->nullable()->comment('audition promo instruction id');
            $table->unsignedBigInteger('audition_id')->nullable();
            $table->unsignedBigInteger('judge_id')->nullable()->comment('if round id is null it will use for audition instruction');
            $table->unsignedBigInteger('round_id')->nullable();

            $table->longText('instruction')->nullable();
            $table->longText('description')->nullable();
            $table->string('video')->nullable();
            $table->string('image')->nullable();
            $table->string('document')->nullable();
            $table->date('submission_end_date')->nullable();
            $table->integer('status')->default(0)->comment('0 = default, 1 = judge updated instruction ');

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
        Schema::dropIfExists('audition_promo_instruction_send_infos');
    }
}
