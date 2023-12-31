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
            $table->float('unit_price')->nullable();
            $table->integer('total_items')->nullable();
            $table->integer('total_selling')->nullable();
            $table->float('delivery_charge')->nullable();
            $table->float('tax')->nullable();
            $table->unsignedBigInteger('superstar_id')->nullable();
            $table->unsignedBigInteger('created_by_id')->nullable();
            $table->unsignedBigInteger('superstar_admin_id')->nullable();
            $table->string('keywords')->nullable();
            $table->integer('post_status')->nullable()->comment('0 = Admin Status, 1 = Star Status');
            $table->integer('status')->default(0)->comment('0 = MA Pending Status, 1 = MA Approved Status');
            $table->string('image')->nullable();
            $table->timestamp('approved_date')->nullable();
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('subcategory_id')->references('id')->on('sub_categories')->onDelete('cascade');
            $table->foreign('superstar_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('created_by_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('superstar_admin_id')->references('id')->on('users')->onDelete('cascade');
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
