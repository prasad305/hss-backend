<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->nullable();
            $table->string('marketplace_id')->nullable();
            $table->string('country_id')->nullable();
            $table->string('state_id')->nullable();
            $table->string('city_id')->nullable();
            $table->string('area')->nullable();
            $table->string('phone')->nullable();
            $table->string('items')->nullable();
            $table->string('unit_price')->nullable();
            $table->string('delivery_charge')->nullable();
            $table->string('total_price')->nullable();
            $table->string('card_no')->nullable();
            $table->string('expire_date')->nullable();
            $table->string('cvc')->nullable();
            $table->string('status')->nullable();
            $table->date('delivery_at')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
