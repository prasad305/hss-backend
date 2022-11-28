<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSouvenirAppliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('souvenir_applies', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('country_id')->nullable();
            $table->unsignedBigInteger('state_id')->nullable();
            $table->unsignedBigInteger('city_id')->nullable();
            $table->unsignedBigInteger('souvenir_id')->nullable();
            $table->longText('description')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('star_id')->nullable();
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->string('image')->nullable();
            $table->string('area')->nullable();
            $table->string('mobile_no')->nullable();
            $table->string('invoice_no')->nullable();
            $table->float('total_amount')->nullable();
            $table->integer('is_delete')->default(0)->comment('1 = Admin Soft Delete');
            $table->integer('status')->default(0)->comment('0 = pending , 1 = approved for payment, 2 = Payment Complete, 3 = Processing, 4 = Product Received, 5 = Processing, 6 = Out for Delivery, 7 = Delivered');
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
        Schema::dropIfExists('souvenir_applies');
    }
}
