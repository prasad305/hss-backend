<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJuryGroupsTable extends Migration
{
    
    public function up()
    {
        Schema::create('jury_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('category_id');
            $table->integer('status')->default(1);
            $table->timestamps();
        });
    }

  
    public function down()
    {
        Schema::dropIfExists('jury_groups');
    }
}
