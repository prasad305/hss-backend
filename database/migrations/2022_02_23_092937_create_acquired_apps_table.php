<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAcquiredAppsTable extends Migration
{
    
    public function up()
    {
        Schema::create('acquired_apps', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bidding_id');
            $table->unsignedBigInteger('payment_id');
            $table->integer('card_number');
            $table->integer('ccv');
            $table->string('expiry_date');
            $table->string('name');
            $table->string('phone');
            $table->boolean('status')->default(0);
            $table->timestamps();
        });
    }
  
    public function down()
    {
        Schema::dropIfExists('acquired_apps');
    }
}
