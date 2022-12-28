<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCurrenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('currencies', function (Blueprint $table) {
            $table->id();
            $table->string('country')->nullable();
            $table->string('currency')->nullable();
            $table->string('currency_code')->nullable();
            $table->string('symbol')->nullable();
            $table->string('country_code')->nullable();
            $table->float('currency_value')->nullable();
            $table->integer('minute')->nullable();
            $table->integer('hours')->nullable();
            $table->string('time_action')->nullable();
            $table->tinyInteger('currency_status')->default(0)->comment('inactive = 0 , active = 1');
            $table->tinyInteger('status')->default(1);
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
        Schema::dropIfExists('currencies');
    }
}
