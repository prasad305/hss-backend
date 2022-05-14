<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuperStarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('super_stars', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('star_id');
            $table->string('star_type')->nullable();
            $table->unsignedBigInteger('admin_id');
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('sub_category_id')->nullable();
            $table->text('terms_and_condition')->nullable();
            $table->longText('description')->nullable();
            $table->string('qr_code')->nullable();
            $table->string('image')->nullable();
            $table->string('agreement')->nullable();
            $table->boolean('status')->default(0)->comment('0 = active , 1 = deactive');
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
        Schema::dropIfExists('super_stars');
    }
}
