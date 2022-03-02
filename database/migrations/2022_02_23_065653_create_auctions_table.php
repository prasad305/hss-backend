<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuctionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auctions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('star_id')->nullable();
            $table->string('name');
            $table->string('title');
            $table->string('type')->nullable();
            $table->unsignedBigInteger('owner_id')->nullable();
            $table->unsignedBigInteger('buyer_id')->nullable();
            $table->integer('base_price');
            $table->longText('details');
            $table->string('product_image')->nullable();
            $table->string('banner')->nullable();
            $table->timestamp('bid_from')->nullable();
            $table->timestamp('bid_to')->nullable();
            $table->boolean('status');
            $table->boolean('product_status')->default(0)->comment('0=unsold,1=sold');
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
        Schema::dropIfExists('auctions');
    }
}
