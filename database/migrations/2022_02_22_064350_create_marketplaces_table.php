<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarketplacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('marketplaces', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->string('description')->nullable();
            $table->string('unit_price')->nullable();
            $table->string('total_items')->nullable();
            $table->string('total_selling')->nullable();
            $table->string('superstar_id')->nullable();
            $table->string('keywords')->nullable();
            $table->string('status')->nullable();
            $table->string('image')->nullable();
            $table->string('expire_date')->nullable();
            $table->string('expire_time')->nullable();
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
        Schema::dropIfExists('marketplaces');
    }
}
