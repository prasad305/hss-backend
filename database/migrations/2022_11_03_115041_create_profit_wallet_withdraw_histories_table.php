<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfitWalletWithdrawHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profit_wallet_withdraw_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('profit_share_id')->nullable();
            $table->string('user_type')->nullable();
            $table->double('withdraw_amount', 8, 2)->nullable();
            $table->integer('status')->nullable()->comment('0=pending,1=processing, 2=success,3=failed');
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
        Schema::dropIfExists('profit_wallet_withdraw_histories');
    }
}
