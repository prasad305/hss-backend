<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWalletPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wallet_payments', function (Blueprint $table) {
            $table->id();
            $table->integer('packages_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->string('holder_name')->nullable();
            $table->string('card_no')->nullable();
            $table->string('expire_date')->nullable();
            $table->integer('cvv')->nullable();
            $table->integer('status')->default(0);
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
        Schema::dropIfExists('wallet_payments');
    }
}
