<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSouvenirsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('souvenirs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('star_id')->nullable();
            $table->string('title')->nullable();
            $table->string('brand')->nullable();
            $table->text('details')->nullable();
            $table->float('price')->nullable();
            $table->integer('quantity')->nullable();
            $table->boolean('status')->default(0)->comment('0 = running , 1 = closed');
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
        Schema::dropIfExists('souvenirs');
    }
}
