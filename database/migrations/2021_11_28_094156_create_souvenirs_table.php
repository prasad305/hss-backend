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
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->text('description')->nullable();
            $table->text('instruction')->nullable();
            $table->float('price')->nullable();
            $table->integer('admin_id')->nullable();
            $table->integer('star_id')->nullable();
            $table->string('banner')->nullable();
            $table->integer('approval_status')->default(0)->comment('0 = admin approval , 1 = star approval');
            $table->integer('status')->default(0)->comment('0 = inactive , 1 = active');
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
