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
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('subcategory_id')->nullable();
            $table->string('slug')->nullable();
            $table->longText('description')->nullable();
            $table->longText('terms_conditions')->nullable();
            $table->integer('unit_price')->nullable();
            $table->integer('total_items')->nullable();
            $table->integer('total_selling')->nullable();
            $table->integer('delivery_charge')->nullable();
            $table->integer('tax')->nullable();
            $table->unsignedBigInteger('superstar_id')->nullable();
            $table->integer('created_by')->nullable();
            $table->unsignedBigInteger('superstar_admin_id')->nullable();
            $table->string('keywords')->nullable();
            $table->integer('post_status')->nullable();
            $table->integer('status')->default(0);
            $table->string('image')->nullable();
            $table->timestamp('approved_date')->nullable();
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
