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
            $table->integer('category_id')->nullable();
            $table->integer('country_id')->nullable();
            $table->integer('state_id')->nullable();
            $table->integer('city_id')->nullable();
            $table->integer('souvenir_id')->nullable();
            $table->text('description')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('star_id')->nullable();
            $table->integer('admin_id')->nullable();
            $table->string('image')->nullable();
            $table->string('area')->nullable();
            $table->string('mobile_no')->nullable();
            $table->integer('status')->default(0)->comment('0 = pending , 1 = approved, 2 = Payment Complete');
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
