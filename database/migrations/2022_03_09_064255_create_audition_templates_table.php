<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuditionTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audition_templates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('judge_id')->nullable();
            $table->unsignedBigInteger('audition_id')->nullable();
            $table->text('banner')->nullable();
            $table->integer('status')->default(0)->comment('0 = unactive, 1= active');
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
        Schema::dropIfExists('audition_templates');
    }
}
