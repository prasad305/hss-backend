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
            $table->unsignedBigInteger('souvenir_create_id')->nullable();
            $table->unsignedBigInteger('souvenir_apply_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('payment_method')->nullable();
            $table->boolean('payment_status')->nullable();
            $table->string('card_holder_name')->nullable();
            $table->string('card_no')->nullable();
            $table->string('card_expire_date')->nullable();
            $table->integer('card_cvv')->nullable();
            $table->float('total_amount')->nullable();
            $table->integer('status')->nullable();
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
