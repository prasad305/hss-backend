<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBiddingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('biddings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('auction_id')->nullable();
            $table->string('name');
            $table->float('amount');
            $table->integer('notify_status')->default(0);
            $table->integer('win_status')->default(0);
            $table->integer('applied_status')->default(0);
            $table->timestamp('checkout_time')->nullable();
            $table->boolean('status')->nullable();


            $table->boolean('payment_status')->nullable();
            $table->timestamp('payment_last_date')->nullable();
            $table->string('card_holder_name')->nullable();
            $table->string('account_no')->nullable();


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
        Schema::dropIfExists('biddings');
    }
}
