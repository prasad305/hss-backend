<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGreetingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('greetings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('created_by_id')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('star_id')->nullable();
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->string('title')->nullable();
            $table->longText('instruction')->nullable();
            $table->string('banner')->nullable();
            $table->string('video')->nullable();
            $table->float('cost')->nullable();
            // $table->date('date')->nullable();
            // $table->integer('participant_number')->nullable();
            // $table->timestamp('registration_start_date')->nullable();
            // $table->timestamp('registration_end_date')->nullable();
            $table->boolean('publish_status')->default(0);
            $table->integer('star_approve_status')->default(0)->comment('1 = star approve | 2 = super Admin Approved');
            $table->boolean('status')->nullable();
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
        Schema::dropIfExists('greetings');
    }
}
