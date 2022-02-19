<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('reported_user_id')->nullable();
            $table->unsignedBigInteger('against_user_id')->nullable();
            $table->string('issue')->nullable();
            $table->string('document')->nullable();
            $table->timestamp('date')->nullable();
            $table->boolean('status')->default(0)->comment('0 = closed , 1 = active');
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
        Schema::dropIfExists('reports');
    }
}
