<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarketplaceOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('marketplace_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('invoice_no')->nullable();
            $table->string('order_no')->nullable();
            $table->unsignedBigInteger('marketplace_id')->nullable();
            $table->unsignedBigInteger('superstar_id')->nullable();
            $table->unsignedBigInteger('superstar_admin_id')->nullable();
            $table->unsignedBigInteger('country_id')->nullable();
            $table->unsignedBigInteger('state_id')->nullable();
            $table->unsignedBigInteger('city_id')->nullable();
            $table->string('area')->nullable();
            $table->string('phone')->nullable();
            $table->integer('items')->nullable();
            $table->float('unit_price')->nullable();
            $table->float('delivery_charge')->nullable();
            $table->float('tax')->nullable();
            $table->float('total_price')->nullable();
            $table->string('holder_name')->nullable();
            $table->string('card_no')->nullable();
            $table->string('card_holder_name')->nullable();
            $table->string('account_no')->nullable();
            $table->timestamp('payment_date')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('payment_status')->nullable();
            $table->string('expire_date')->nullable();
            $table->integer('cvc')->nullable();
            $table->integer('status')->nullable()->comment('1 = Ordered, 2 = Received, 3 = Out for Delivery, 4 = Delivered');
            $table->timestamp('delivery_at')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('marketplace_id')->references('id')->on('marketplaces')->onDelete('cascade');
            $table->foreign('superstar_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('superstar_admin_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
            $table->foreign('state_id')->references('id')->on('states')->onDelete('cascade');
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('marketplace_orders');
    }
}