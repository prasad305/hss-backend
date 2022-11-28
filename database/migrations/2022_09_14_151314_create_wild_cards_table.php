<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWildCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wild_cards', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('audition_id')->nullable();
            $table->unsignedBigInteger('start_round_info_id')->nullable();
            $table->unsignedBigInteger('end_round_info_id')->nullable();
            $table->integer('start_round_num')->nullable();
            $table->integer('end_round_num')->nullable();
            $table->integer('status')->default(0)->comment('1=running,2=completed');
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
        Schema::dropIfExists('wild_cards');
    }
}
