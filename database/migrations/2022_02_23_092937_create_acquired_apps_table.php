<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAcquiredAppsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acquired_apps', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bidding_id');
            $table->unsignedBigInteger('payment_id');
            $table->string('name');
            $table->string('phone');
            $table->boolean('status')->default(0);
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
        Schema::dropIfExists('acquired_apps');
    }
}
