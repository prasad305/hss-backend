<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVirtualtoursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('virtualtours', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->longText('link')->nullable();
            $table->longText('video')->nullable();
            $table->string('type')->nullable();
            $table->enum('status', [0,1])->default(1);
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
        Schema::dropIfExists('virtualtours');
    }
}
