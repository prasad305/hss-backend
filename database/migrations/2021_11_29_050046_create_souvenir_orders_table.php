<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSouvenirOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('souvenir_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('souvenir_id')->nullable();
            $table->timestamp('order_date')->nullable();
            $table->integer('quantity')->nullable();
            $table->integer('delivery_status')->nullable();
            $table->timestamp('delivery_date')->nullable();
            $table->float('amount')->nullable();
            $table->float('price')->nullable();
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
        Schema::dropIfExists('souvenir_orders');
    }
}
