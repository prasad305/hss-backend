<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSouvenirPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('souvenir_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('souvenir_order_id')->nullable();
            $table->timestamp('payment_date')->nullable();
            $table->string('payment_method')->nullable();
            $table->boolean('payment_status')->nullable();
            $table->string('card_holder_name')->nullable();
            $table->float('amount')->nullable();
            $table->string('transaction_id')->nullable();
            $table->integer('status')->nullable();
            $table->string('ccv')->nullable();



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
        Schema::dropIfExists('souvenir_payments');
    }
}
